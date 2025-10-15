<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Services\GenerateTokensService;
use Illuminate\Http\Request;

class RefreshTokenController extends ApiController
{
    public function __invoke(Request $request, GenerateTokensService $generateTokensService)
    {
        return $this->runWithTransaction(function () use ($request, $generateTokensService) {
            /**
             * @var \App\Models\User $user
             */
            $user = $request->user();
            $tokens = $generateTokensService($user, $request->header('User-Agent'));
            return [
                'access_token' => $tokens['access_token'],
                'remember_token' => $tokens['remember_token'],
            ];
        }, __('messages.token_generated'));
    }
}
