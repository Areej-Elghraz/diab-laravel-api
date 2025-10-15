<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

abstract class ApiController
{
    protected function resource(string $key)
    {
        return __('messages.resources.' . $key . '.singular');
    }

    protected function resources(string $key)
    {
        return __('messages.resources.' . $key . '.plural');
    }

    public function successResponse(string $message = 'Success!', int $status = 200, array $parameters = [])
    {
        $response = [
            'message' => $message,
            'data' => $parameters
        ];

        // if (!empty($parameters)) {
        //     $response = array_merge($response, $parameters);
        // }

        return response()->json($response, $status);
    }

    public function errorResponse(string $message = 'Error!', int $status = 400, array $parameters = [])
    {
        $response = [
            'message' => $message
        ];

        if (!empty($parameters)) {
            $response = array_merge($response, $parameters);
        }

        return response()->json($response, $status);
    }

    protected function runWithTransaction(\Closure $callback, string $successMessage, array $uploadedPaths = [], int $successStatus = 200)
    {
        DB::beginTransaction();

        try {
            $result = $callback() ?? [];

            DB::commit();

            return $this->successResponse(
                message: $successMessage,
                status: ($successStatus < 227)
                    ? $successStatus
                    : 200,
                parameters: $result ?? []
            );
        } catch (ValidationException $e) {
            DB::rollBack();
            return $this->errorResponse(
                message: collect($e->errors())->flatten()->first(),
                status: 422,
                parameters: ['errors' => $e->errors()]
            );
        } catch (\Exception $e) {
            DB::rollBack();
            // Log::error($e);

            if (!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            $code = $e->getCode();
            if ($code && is_numeric($code) && count_chars((string) $code) == 3 && in_array(count_chars((string) $code)[0], ['1', '2', '3', '4', '5'])) {
                $statusCode =  $code;
            }

            return $this->errorResponse(
                message: $e->getMessage(),
                status: $statusCode ?? 400,
                // parameters: ['error' => $e->getMessage()]
            );
        }
    }
}
