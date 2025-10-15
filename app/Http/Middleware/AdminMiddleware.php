<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            throw new \Exception(__('auth.unauthorized'), 401);
        }
        if (!$request->user()->isAdmin()) {
            throw new \Exception(__('auth.unauthorized'), 403);
        }
        return $next($request);
    }

    /// phone verification public function handle(Request $request, Closure $next): Response
    // public function handle(Request $request, Closure $next): Response
    // {
    //     $user = $request->user();

    //     if (is_null($user->email_verified_at) && is_null($user->phone_verified_at)) {
    //         return response()->json([
    //             'message' => 'Your account is not verified yet. Please verify your email or phone.'
    //         ], 403);
    //     }
    //     return $next($request);
    // }
}
