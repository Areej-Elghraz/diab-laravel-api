<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\LogoutRequest;

class LogoutController extends ApiController
{
    public function __invoke(LogoutRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {

            $validated = $request->validated();

            /** @var \App\Models\User $user */
            $user = auth('sanctum')->user();

            if (!empty($validated['all_devices'])) {
                $user->tokens()->delete();
            } else {
                $user->tokens()?->where('name', $user->currentAccessToken()?->name)->delete();
                // $user->currentAccessToken()->delete();
            }
            return [];
        },  __('messages.logout_success'));
    }
}
