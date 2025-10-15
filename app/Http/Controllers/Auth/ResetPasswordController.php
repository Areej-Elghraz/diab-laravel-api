<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends ApiController
{
    public function __invoke(ResetPasswordRequest $request)
    {
        return $this->runWithTransaction(function () use ($request) {

            $validated = $request->validated();
            $inputType = filter_var($validated['input'], FILTER_VALIDATE_EMAIL)
                ? 'email'
                : 'username';

            $user       = User::where($inputType, $validated['input'])->first();
            $expiration = config('auth.passwords.users.expire', 10); //minutes
            $otpRecord  = DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->first();

            if (!$user) {
                throw ValidationException::withMessages(['input' => __('validation.invalid_value', ['attribute' => __('validation.attributes.' . $inputType)])]);
            }

            if (!$otpRecord) {
                throw ValidationException::withMessages(['otp' => __('validation.invalid_value', ['attribute' => __('validation.attributes.otp')])]);
            }

            if ($otpRecord) {
                $createdAt    = \Carbon\Carbon::parse($otpRecord->created_at);
                $minutesSince = $createdAt->diffInMinutes(now());
                if ($minutesSince >= $expiration) {
                    throw ValidationException::withMessages(['otp' => __('messages.already_otp_resent')]);
                }
                if (!Hash::check($validated['otp'], $otpRecord->token)) {
                    throw ValidationException::withMessages(['otp' => __('validation.invalid_value', ['attribute' => __('validation.attributes.otp')])]);
                }
            }

            if (Hash::check($validated['new_password'], $user->password)) {
                throw ValidationException::withMessages(['new_password' => __('validation.new_password_must_differ')]);
            }

            $user->update([
                'password' => Hash::make($validated['new_password']),
            ]);

            /// Fire reset event (optional)
            event(new PasswordReset($user));

            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->delete();

            return [];
        },  __('messages.password_reset'));
    }
}
