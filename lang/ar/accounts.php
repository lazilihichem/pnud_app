<?php

/*
|--------------------------------------------------------------------------
| Accounts & Access (Module 01) — Arabic
|--------------------------------------------------------------------------
|
| Mirrors lang/fr/accounts.php key for key. Draft translations, to be
| replaced by the approved texts supplied by the client (SRS 5.5).
|
*/

return [

    'registration' => [
        'required' => 'يرجى ملء الحقول الإلزامية.',
        'email_taken' => 'يوجد حساب مسجل بهذا العنوان بالفعل.',
        'passwords_differ' => 'كلمتا المرور غير متطابقتين.',
        'cv_format' => 'الصيغ المقبولة: PDF، DOC، DOCX — 5 ميغابايت كحد أقصى.',
    ],

    'sign_in' => [
        'invalid_credentials' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        'suspended' => 'حسابك موقوف. يرجى التواصل مع فريق المنصة.',
        'refused' => 'لم يتم قبول تسجيلك. :reason',
        'throttled' => 'محاولات كثيرة جدًا. انتظر :seconds ثانية قبل المحاولة مجددًا.',
        'code_incorrect' => 'الرمز غير صحيح.',
        'code_expired' => 'انتهت صلاحية الرمز.',
        'code_exhausted' => 'رموز خاطئة كثيرة: لم يعد هذا الرمز صالحًا. اطلب رمزًا جديدًا.',
        'code_pending' => 'يستغرق إرسال الرمز وقتًا أطول من المتوقع.',
        'resend_too_early' => 'يمكنك إعادة إرسال الرمز بعد :seconds ثانية.',
        'code_sent' => 'تم إرسال رمز جديد إليك.',
        'mail' => [
            'code_subject' => 'رمز تسجيل الدخول الخاص بك',
            'code_line' => 'رمز تسجيل الدخول الخاص بك هو: :code',
            'code_validity' => 'صالح لمدة 5 دقائق ويُستخدم مرة واحدة فقط.',
            'code_ignore' => 'إذا لم تكن أنت من يحاول تسجيل الدخول، فقم بتغيير كلمة المرور.',
            'throttled_subject' => 'محاولات تسجيل الدخول إلى حسابك',
            'throttled_line' => 'استهدفت عدة محاولات فاشلة لتسجيل الدخول حسابك، وقد تم إبطاؤها.',
            'throttled_safe' => 'حسابك غير مقفل. إذا لم تكن أنت، ننصحك بتغيير كلمة المرور.',
        ],
    ],

    'attributes' => [
        'role' => 'أنا',
        'name' => 'الاسم الكامل',
        'email' => 'البريد الإلكتروني',
        'organisation' => 'المنظمة',
        'wilaya_id' => 'الولاية',
        'fonction' => 'الوظيفة / التخصص',
        'linkedin_url' => 'حساب LinkedIn',
        'education' => 'التكوين / الشهادات',
        'cv' => 'السيرة الذاتية',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'terms' => 'أوافق على شروط الاستخدام',
    ],

    'roles' => [
        'entrepreneur' => 'مقاول / منظمة اقتصاد اجتماعي وتضامني',
        'accompagnateur' => 'مرافق',
        'formateur' => 'مكوّن',
        'citoyen' => 'مواطن',
        'admin' => 'مسؤول',
        'super_admin' => 'مسؤول عام',
    ],

];
