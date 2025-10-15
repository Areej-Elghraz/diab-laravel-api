<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ForgetPasswordRequest;
use App\Models\User;
use App\Services\SendOtpService;
use Illuminate\Validation\ValidationException;

class ForgetPasswordController extends ApiController
{
    public function __invoke(ForgetPasswordRequest $request, SendOtpService $sendOtpService)
    { /// message delay?!
        return $this->runWithTransaction(function () use ($request, $sendOtpService) {

            $validated = $request->validated();
            $inputType = filter_var($validated['input'], FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'username';

            $user = User::where($inputType, $validated['input'])->first();

            if (!$user) {
                throw ValidationException::withMessages([
                    'input' => __('validation.invalid_value', ['attribute' => __('validation.attributes.' . $inputType)])
                ]);
            }

            $sendOtpService($user, $validated['url']);
            return [];
        },  __('messages.otp_sent'));
    }
}
