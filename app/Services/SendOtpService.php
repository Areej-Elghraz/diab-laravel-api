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
    $otp                = rand(100000, 999999);
    $otpRecord          = DB::table('password_reset_tokens')->where('email', $user->email)->first();
    $expiration         = config('auth.passwords.users.expire', 10); //minutes
    $expirationsSeconds = $expiration * 60; //seconds
    $throttle           = config('auth.passwords.users.throttle', 1) * 60; //seconds
    $maxTimes           = config('auth.passwords.users.times', 3); //minutes

    if ($otpRecord) {
      $createdAt    = \Carbon\Carbon::parse($otpRecord->created_at);
      $secondsSince = $createdAt->diffInSeconds(now());
      $times        = $otpRecord->times ?? 0;
      if ($secondsSince > $expirationsSeconds) {
        $times = 0;
      }
      if ($times >= $maxTimes) {
        if ($secondsSince <= $throttle) {
          throw new \Exception(__('messages.wait_before_resend', ['seconds' => $throttle, 'remain_seconds' => (int) ($throttle - $secondsSince)]), 429);
        }
        $times = 0;
      }
    }

    $newTimes = ($times ?? 0) + 1;

    DB::table('password_reset_tokens')->updateOrInsert(
      ['email' => $user->email],
      [
        'token'      => Hash::make($otp),
        'created_at' => now(),
        'times'      => $newTimes,
      ]
    );
    Mail::to($user->email)->send(new OtpMail($otp, $expiration, $maxTimes, $maxTimes - $newTimes, $user->name, $url));
  }
}
