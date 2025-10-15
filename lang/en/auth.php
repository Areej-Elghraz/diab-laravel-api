<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'   => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    // Custom authentication messages.
    'unauthorized_no_token'      => 'Unauthorized: No token.',
    'unauthorized_token_expired' => 'Unauthorized: Token expired.',
    'unauthorized'               => 'Unauthorized!',
    'forbidden_action'           => 'You are not allowed to perform this action.',
    'csrf_token_mismatch'        => 'The session has expired. Please refresh the page and try again.',
    'email_not_verified'         => 'Your account email address is not verified.',
    'account_not_verified'       => 'Your account is not verified!',
    'invalid_ability'            => 'You do not have the required ability to perform this action.',
    'invalid_scope'              => 'You do not have the required scope to access this resource.',
];
