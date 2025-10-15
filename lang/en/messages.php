<?php
return [
  // Success messages.
  'login_success'   => 'Logged in successfully!',
  'logout_success'  => 'Logged out successfully!',
  'password_reset'  => 'Password reset successfully!',
  'otp_sent'        => '(OTP) sent to your email.',
  'otp_verified'    => 'OTP verified successfully!',
  'token_generated' => 'Token Created successfully!',
  // 'images_actions.deleted_success' => ': resource images deleted successfully!',

  // Resources.
  'resources' => [
    'user'         => ['singular' => 'User',        'plural' => 'Users',],
    'banner'       => ['singular' => 'Banner',        'plural' => 'Banners',],
    'category'     => ['singular' => 'Category',      'plural' => 'Categories',],
    'phonenumber'  => ['singular' => 'Phone number',  'plural' => 'Phone numbers',],
    'product'      => ['singular' => 'Product',       'plural' => 'Products',],
    'productimage' => ['singular' => 'Image',         'plural' => 'Images',],
    'image'        => ['singular' => 'Image',         'plural' => 'Images',],
    'all_images'   => ['singular' => 'All Images',    'plural' => 'All Images',],
    'profile'      => ['singular' => 'Profile data',  'plural' => 'Profiles data',],
    'sociallink'   => ['singular' => 'Social link',   'plural' => 'Social links',],
  ],

  'actions' => [
    'retrieved_success'      => ':resource retrieved successfully!',
    'created_success'        => ':resource created successfully!',
    'updated_success'        => ':resource updated successfully!',
    'deleted_success'        => ':resource deleted successfully!',
    'restored_success'       => ':resource restored successfully!',
    'force_deleted_success'  => ':resource permanently deleted!',
  ],

  // Error messages.
  'image_not_found_in_product' => 'Image not found in this product!',
  'product_has_no_images'      => 'Product has no images to delete!',
  'cannot_delete_position'     => 'You can\'t delete ":position" image, Try to replace it!',
  '404_not_found'              => ':model Not Found!',
  'method_not_allowed'         => 'The request method is not allowed.',
  'too_many_requests'          => 'Too many requests. Please try again later.',
  'database_error'             => 'An error occurred while processing the database.',
  'http_error'                 => 'An error occurred while processing the request.',
  'internal_server_error'      => 'An internal server error occurred. Please try again later.',
  'file_error'                 => 'An error occurred while processing the file.',
  'external_api_error'         => 'An error occurred while communicating with an external service. Please try again later.',
  'invalid_json'               => 'The provided JSON data is invalid.',
  'max_reached'                => 'You have reached the maximum allowed number of :object (:max).',
  'already_otp_resent'         => 'OTP already sent to your email!',
  'wait_before_resend'         => 'Please wait :minutes minute(s) before resending the code.',

  // Mail messages.
  'mail' => [
    'title'             => 'Email Verification',
    'greeting'          => 'Hello',
    'body'              => 'Use the following One-Time Password (OTP) to verify your email:',
    'verify_button'     => 'Verify Here',
    'expire'            => 'This code will expire in <strong>:minutes minutes</strong>.',
    'ignore'            => 'If you didn’t request this, you can safely ignore this email.',
    'footer'            => 'All rights reserved.',
    'verification_code' => 'Verification Code',
  ]
];
