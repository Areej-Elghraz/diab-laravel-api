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

    'failed'   => 'بيانات الاعتماد هذه غير متطابقة مع سجلاتنا.',
    'password' => 'كلمة المرور المقدمة غير صحيحة.',
    'throttle' => 'عدد محاولات تسجيل الدخول كبير جدًا. يرجى المحاولة مرة أخرى بعد :seconds ثانية.',

    // Custom authentication messages.
    'unauthorized_no_token'      => 'غير مصرح: لا يوجد رمز.',
    'unauthorized_token_expired' => 'غير مصرح: انتهت صلاحية الرمز.',
    'unauthorized'               => 'غير مصرح!',
    'forbidden_action'           => 'غير مسموح بتنفيذ هذا الإجراء.',
    'csrf_token_mismatch'        => 'انتهت صلاحية الجلسة. يرجى تحديث الصفحة والمحاولة مرة أخرى.',
    'email_not_verified'         => 'لم يتم التحقق من عنوان بريدك الإلكتروني.',
    'account_not_verified'       => 'لم يتم التحقق من حسابك!',
    'invalid_ability'            => 'ليس لديك الصلاحية لتنفيذ هذا الإجراء.',
    'invalid_scope'              => 'ليست لديك النطاقات المطلوبة للوصول إلى هذا المورد.',
];
