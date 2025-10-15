<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class SendOtpService
{
  public function __invoke(User $user, string $url)
  {
    $otp          = rand(100000, 999999);
    $otpRecord    = DB::table('password_reset_tokens')->where('email', $user->email)->first();
    $expiration   = config('auth.passwords.users.expire', 10); //minutes
    $throttle     = config('auth.passwords.users.throttle', 10); //minutes

    if ($otpRecord) {
      $createdAt    = \Carbon\Carbon::parse($otpRecord->created_at);
      $minutesSince = $createdAt->diffInMinutes(now());
      if ($minutesSince <= $expiration) {
        throw new \Exception(__('messages.already_otp_resent'), 409);
      }
      if ($minutesSince <= $throttle) {
        throw new \Exception(__('messages.wait_before_resend', ['minutes' => $throttle - $minutesSince]), 429);
      }
    }

    DB::table('password_reset_tokens')->updateOrInsert(
      ['email' => $user->email],
      [
        'token'      => Hash::make($otp),
        'created_at' => now(),
      ]
    );
    Mail::to($user->email)->send(new OtpMail($otp, $expiration, $user->name, $url));
  }
}
