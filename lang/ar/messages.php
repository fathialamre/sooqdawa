<?php

return [
    'common' => [
        'id' => 'ر.م',
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'all' => 'الكل',
        'yes' => 'نعم',
        'no' => 'لا',
        'save' => 'حفظ',
        'cancel' => 'إلغاء',
        'delete' => 'حذف',
        'edit' => 'تعديل',
        'view' => 'عرض',
        'create' => 'إنشاء',
        'actions' => 'الإجراءات',
        'loading' => 'جارٍ التحميل...',
        'search' => 'بحث',
        'filter' => 'تصفية',
        'reset' => 'إعادة تعيين',
    ],

    'navigation' => [
        'groups' => [
            'administration' => 'الإدارة',
            'user_management' => 'إدارة المستخدمين',
            'system' => 'النظام',
            'content' => 'المحتوى',
        ],
    ],

    'saved_post' => [
        'navigation' => [
            'label' => 'منشور محفوظ',
            'plural_label' => 'المنشورات المحفوظة',
            'group' => 'المحتوى',
        ],
        'form' => [
            'section' => [
                'basic' => [
                    'title' => 'المعلومات الأساسية',
                    'description' => 'اختر المستخدم والمنشور لهذا الإدخال المحفوظ',
                ],
            ],
            'fields' => [
                'user' => 'المستخدم',
                'post' => 'المنشور',
            ],
            'placeholders' => [
                'select_user' => 'اختر مستخدم',
                'select_post' => 'اختر منشور',
            ],
        ],
        'table' => [
            'columns' => [
                'user' => 'المستخدم',
                'post' => 'المنشور',
                'department' => 'القسم',
                'price' => 'السعر',
                'saved_at' => 'تاريخ الحفظ',
                'updated_at' => 'تاريخ التحديث',
            ],
        ],
    ],

    'user_plan' => [    
        'navigation' => [
            'label' => 'خطة المستخدم',
            'plural_label' => 'خطط المستخدمين',
            'group' => 'المحتوى',
            'plural' => 'خطط المستخدمين',
        ],
        'form' => [
            'sections' => [
                'basic' => 'المعلومات الأساسية',
                'dates' => 'معلومات التاريخ',
            ],
            'fields' => [
                'user' => 'المستخدم',
                'plan' => 'الخطة',
                'status' => 'الحالة',
                'starts_at' => 'تاريخ البداية',
                'ends_at' => 'تاريخ الانتهاء',
                'expired_at' => 'تاريخ انتهاء الصلاحية',
                'is_expired' => 'منتهي الصلاحية',
            ],
            'statuses' => [
                'active' => 'نشط',
                'cancelled' => 'ملغي',
                'expired' => 'منتهي الصلاحية',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'user_name' => 'اسم المستخدم',
                'user_email' => 'البريد الإلكتروني للمستخدم',
                'plan_name' => 'اسم الخطة',
                'plan_price' => 'سعر الخطة',
                'status' => 'الحالة',
                'starts_at' => 'تاريخ البداية',
                'ends_at' => 'تاريخ الانتهاء',
                'expired_at' => 'تاريخ انتهاء الصلاحية',
                'cancelled_at' => 'تاريخ الإلغاء',
                'created_at' => 'تاريخ الإنشاء',
            ],
            'statuses' => [
                'active' => 'نشط',
                'cancelled' => 'ملغي',
                'expired' => 'منتهي الصلاحية',
            ],
            'filters' => [
                'status' => 'الحالة',
                'active' => 'نشط',
                'expired' => 'منتهي الصلاحية',
                'by_user' => 'حسب المستخدم',
                'by_plan' => 'حسب الخطة',
            ],
        ],
        'infolist' => [
            'user_information' => 'معلومات المستخدم',
            'plan_information' => 'معلومات الخطة',
            'subscription_details' => 'تفاصيل الاشتراك',
            'timestamps' => 'الطوابع الزمنية',
            'user_name' => 'اسم المستخدم',
            'user_email' => 'البريد الإلكتروني للمستخدم',
            'user_phone' => 'هاتف المستخدم',
            'user_country' => 'بلد المستخدم',
            'plan_name' => 'اسم الخطة',
            'plan_price' => 'سعر الخطة',
            'plan_duration' => 'مدة الخطة',
            'plan_posts' => 'منشورات الخطة',
            'status' => 'الحالة',
            'is_expired' => 'منتهي الصلاحية',
            'starts_at' => 'تاريخ البداية',
            'ends_at' => 'تاريخ الانتهاء',
            'expired_at' => 'تاريخ انتهاء الصلاحية',
            'cancelled_at' => 'تاريخ الإلغاء',
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'تاريخ التحديث',
            'months' => 'أشهر',
            'statuses' => [
                'active' => 'نشط',
                'cancelled' => 'ملغي',
                'expired' => 'منتهي الصلاحية',
            ],
            'is_expired_true' => 'نعم',
            'is_expired_false' => 'لا',
        ],
        'actions' => [
            'add_plan' => 'إضافة خطة للمستخدم',
            'cancel' => [
                'label' => 'إلغاء الخطة',
                'modal' => [
                    'title' => 'إلغاء خطة المستخدم',
                    'description' => 'هل أنت متأكد من أنك تريد إلغاء خطة المستخدم هذه؟ لا يمكن التراجع عن هذا الإجراء.',
                    'confirm' => 'نعم، إلغاء الخطة',
                    'cancel' => 'لا، الاحتفاظ بالخطة',
                ],
                'notification' => [
                    'title' => 'تم إلغاء الخطة',
                    'body' => 'تم إلغاء خطة المستخدم بنجاح.',
                ],
            ],
            'create_modal' => [
                'title' => 'إنشاء خطة مستخدم جديدة',
                'description' => 'تعيين خطة للمستخدم. ستبدأ الخطة فوراً وسيتم إلغاء أي خطة نشطة موجودة.',
                'submit' => 'إنشاء الخطة',
                'cancel' => 'إلغاء',
            ],
        ],
        'fields' => [
            'user' => 'المستخدم',
            'plan' => 'الخطة',
            'immediate_activation' => 'التفعيل الفوري',
        ],
        'placeholders' => [
            'select_user' => 'اختر مستخدم',
            'select_plan' => 'اختر خطة',
        ],
        'helpers' => [
            'plan_selection' => 'اختر خطة نشطة لتعيينها للمستخدم. سيتم حساب مدة الخطة تلقائياً بناءً على الخطة المختارة.',
            'immediate_activation' => 'تفعيل الخطة فوراً (سيتم إلغاء أي خطة موجودة)',
        ],
        'errors' => [
            'user_required' => 'المستخدم مطلوب',
            'plan_required' => 'الخطة مطلوبة',
        ],
        'notifications' => [
            'plan_added' => 'تمت إضافة الخطة بنجاح',
            'plan_added_body' => 'تمت إضافة الخطة :plan للمستخدم :user لمدة :duration',
            'add_error' => 'خطأ في إضافة الخطة',
            'add_error_body' => 'فشل في إضافة الخطة: :error',
        ],
        'months' => 'أشهر',
    ],

    'banner' => [
        'navigation' => [
            'label' => 'لوحة اعلانية',
            'plural_label' => 'اللوحات الاعلانية',
            'group' => 'إدارة المحتوى',
        ],
        'types' => [
            'post' => 'منشور',
            'department' => 'قسم',
            'external_link' => 'رابط خارجي',
            'none' => 'لا شيء',
        ],
        'fields' => [
            'type' => 'النوع',
            'external_link' => 'الرابط الخارجي',
            'is_active' => 'نشط',
            'banner_image' => 'صورة اللوحة اعلانية',
            'post' => 'المنشور',
            'department' => 'القسم',
        ],
        'form' => [
            'section' => [
                'basic' => 'الإعدادات الأساسية',
                'basic_description' => 'تكوين نوع اللوحة اعلانية والحالة',
                'image' => 'صورة اللوحة اعلانية',
                'image_description' => 'رفع صورة اللوحة اعلانية بالأبعاد المناسبة',
                'target' => 'تكوين الهدف',
                'target_description' => 'تكوين المكان الذي يجب أن يربط إليه اللوحة اعلانية',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'banner_image' => 'الصورة',
                'type' => 'النوع',
                'model' => 'نوع النموذج',
                'model_id' => 'معرف النموذج',
                'linked_to' => 'مرتبط بـ',
                'target' => 'الهدف',
                'external_link' => 'الرابط الخارجي',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
                'record' => 'النموذج',
                'show_post' => 'عرض المنشور',
                'show_department' => 'عرض القسم',
            ],
        ],
        'filters' => [
            'type' => 'النوع',
            'is_active' => 'الحالة',
        ],
    ],

    'wallet' => [
        'navigation' => [
            'label' => 'محفظة',
            'plural_label' => 'المحافظ',
            'group' => 'المالية',
        ],
        'fields' => [
            'user' => 'المستخدم',
            'voucher' => 'القسيمة',
            'voucher_placeholder' => 'اختر قسيمة (اختياري)',
            'credit' => 'دائن',
            'debit' => 'مدين',
            'balance' => 'الرصيد',
            'amount' => 'المبلغ',
            'description' => 'الوصف',
            'description_placeholder' => 'أدخل وصف المعاملة...',
            'topup_description_placeholder' => 'أدخل سبب شحن المحفظة (اختياري)...',
        ],
        'form' => [
            'section' => [
                'basic' => 'المعلومات الأساسية',
                'basic_description' => 'اختر المستخدم والقسيمة لهذه المعاملة',
                'transaction' => 'تفاصيل المعاملة',
                'transaction_description' => 'أدخل مبالغ الدائن والمدين والرصيد',
                'details' => 'تفاصيل إضافية',
                'details_description' => 'أضف وصف وملاحظات لهذه المعاملة',
            ],
            'helpers' => [
                'user_selection' => 'اختر مستخدم نشط لشحن محفظته',
                'amount_range' => 'أدخل مبلغ بين 0.01د.ل و 10,000د.ل',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'user' => 'المستخدم',
                'credit' => 'دائن',
                'debit' => 'مدين',
                'balance' => 'الرصيد',
                'voucher' => 'القسيمة',
                'description' => 'الوصف',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
        ],
        'filters' => [
            'user' => 'المستخدم',
            'voucher' => 'القسيمة',
        ],
        'actions' => [
            'topup' => 'شحن',
            'topup_wallet' => 'شحن المحفظة',
        ],
        'modals' => [
            'topup' => [
                'description' => 'إضافة رصيد إلى محفظة المستخدم مباشرة بدون استخدام قسيمة.',
            ],
        ],
        'notifications' => [
            'topup_success' => 'تم شحن المحفظة بنجاح',
            'topup_success_body' => 'تمت إضافة {amount}$ إلى محفظة {user} بنجاح. الرصيد الجديد: {balance}$',
            'topup_error' => 'فشل في شحن المحفظة',
            'topup_error_body' => 'حدث خطأ: {error}',
        ],
        'default_descriptions' => [
            'topup' => 'شحن المحفظة: {amount}$',
        ],
    ],

    'user' => [
        'navigation' => [
            'label' => 'مستخدم',
            'plural_label' => 'المستخدمون',
            'group' => 'إدارة المستخدمين',
        ],
        'sections' => [
            'basic_info' => 'المعلومات الأساسية',
            'security' => 'الأمان',
            'media' => 'الوسائط',
            'notifications' => 'الإشعارات',
        ],
        'fields' => [
            'name' => 'الاسم الكامل',
            'email' => 'عنوان البريد الإلكتروني',
            'type' => 'نوع المستخدم',
            'country' => 'الدولة',
            'is_active' => 'الحالة النشطة',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'avatar' => 'الصورة الشخصية',
            'fcm_token' => 'رمز FCM',   
            'phone' => 'الهاتف',
            ],
        'helpers' => [
            'fcm_token' => 'رمز Firebase Cloud Messaging للإشعارات الفورية',
        ],
        'types' => [
            'admin' => 'مدير',
            'customer' => 'عميل',
            'company' => 'شركة',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'avatar' => 'الصورة الشخصية',
                'name' => 'الاسم',
                'email' => 'البريد الإلكتروني',
                'phone' => 'الهاتف',
                'type' => 'النوع',
                'country' => 'الدولة',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
        ],
        'filters' => [
            'type' => 'نوع المستخدم',
            'country' => 'الدولة',
            'is_active' => 'الحالة النشطة',
        ],
        'actions' => [
            'change_password' => 'تغيير كلمة المرور',
            'block' => 'حظر',
            'unblock' => 'إلغاء الحظر',
            'block_user' => 'حظر المستخدم',
            'unblock_user' => 'إلغاء حظر المستخدم',
        ],
        'modals' => [
            'change_password' => [
                'title' => 'تغيير كلمة مرور المستخدم',
                'description' => 'أدخل كلمة مرور جديدة لحساب هذا المستخدم.',
                'new_password' => 'كلمة المرور الجديدة',
                'confirm_password' => 'تأكيد كلمة المرور الجديدة',
                'submit' => 'تغيير كلمة المرور',
            ],
            'block' => [
                'description' => 'هل أنت متأكد من أنك تريد حظر :name؟ لن يتمكن من الوصول إلى النظام بعد الآن.',
            ],
            'unblock' => [
                'description' => 'هل أنت متأكد من أنك تريد إلغاء حظر :name؟ سيتمكن من الوصول إلى النظام مرة أخرى.',
            ],
        ],
        'notifications' => [
            'password_changed' => 'تم تغيير كلمة المرور بنجاح',
            'user_blocked' => 'تم حظر المستخدم :name بنجاح',
            'user_unblocked' => 'تم إلغاء حظر المستخدم :name بنجاح',
        ],
        'infolist' => [
            'email_copied' => 'تم نسخ البريد الإلكتروني إلى الحافظة',
            'no_country' => 'لم يتم تحديد الدولة',
            'no_fcm_token' => 'لا يوجد رمز FCM',
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'آخر تحديث',
            'deleted_at' => 'تاريخ الحذف',
            'not_deleted' => 'غير محذوف',
            'email_verified' => 'تم التحقق من البريد الإلكتروني',
            'email_not_verified' => 'لم يتم التحقق من البريد الإلكتروني',
            'password_status' => 'كلمة المرور',
            'password_set' => 'تم تعيين كلمة المرور',
        ],
        'pages' => [
            'view' => [
                'title' => 'عرض :name',
            ],
        ],
        'relations' => [
            'followers' => [
                'title' => 'المتابعون',
                'user' => 'المستخدم',
                'followed_at' => 'تاريخ المتابعة',
                'total_followers' => 'إجمالي المتابعين',
            ],
            'following' => [
                'title' => 'المتابَعون',
                'user' => 'المستخدم',
                'followed_at' => 'تاريخ المتابعة',
                'total_following' => 'إجمالي المتابَعين',
            ],
        ],
    ],

    'settings' => [
        'title' => 'الإعدادات',
        'heading' => 'إعدادات التطبيق',
        'navigation' => [
            'label' => 'الإعدادات',
        ],
        'sections' => [
            'application_information' => 'معلومات التطبيق',
            'application_information_description' => 'معلومات التطبيق الأساسية وتفاصيل الاتصال',
            'application_logo' => 'شعار التطبيق',
            'application_logo_description' => 'رفع شعار التطبيق (الحجم المفضل: 300×300 بكسل)',
        ],
        'fields' => [
            'app_name' => 'اسم التطبيق',
            'email' => 'البريد الإلكتروني',
            'phone' => 'الهاتف',
            'address' => 'العنوان',
            'full_address' => 'العنوان الكامل',
            'logo' => 'الشعار',
            'logo_helper_text' => 'الحد الأقصى لحجم الملف: 2 ميجابايت. الصيغ المقبولة: JPEG, PNG, GIF, WebP',
        ],
        'actions' => [
            'save' => 'حفظ الإعدادات',
        ],
        'updated' => 'تم تحديث الإعدادات',
        'updated_description' => 'تم تحديث إعدادات التطبيق بنجاح.',
    ],

    'customer' => [
        'actions' => [
            'topup_wallet' => 'شحن المحفظة',
            'topup_wallet_description' => 'إضافة أموال إلى رصيد محفظة العميل.',
            'topup_confirm' => 'شحن الآن',
        ],
        'fields' => [
            'amount' => 'المبلغ',
            'notes' => 'ملاحظات',
        ],
        'helpers' => [
            'topup_amount' => 'أدخل مبلغ الشحن.',
            'topup_notes' => 'أدخل ملاحظات الشحن.',
        ],
        'notifications' => [
            'topup_initiated' => 'تم بدء الشحن',
            'topup_amount' => 'تم إضافة :amount إلى المحفظة',
        ],
    ],

    'auth' => [
        'otp_sent' => 'تم إرسال رمز التحقق بنجاح',
        'otp_generated' => 'تم إنشاء رمز التحقق بنجاح',
        'otp_already_generated' => 'تم إنشاء رمز التحقق مسبقاً',
        'registration_failed' => 'فشل في التسجيل',
        'otp_expired' => 'انتهت صلاحية رمز التحقق أو لم يتم العثور عليه',
        'invalid_otp' => 'رمز التحقق غير صحيح',
        'registration_successful' => 'تم التسجيل بنجاح',
        'registration_verification_failed' => 'فشل في التحقق من التسجيل',
        'invalid_credentials' => 'بيانات الاعتماد المقدمة غير صحيحة',
        'login_successful' => 'تم تسجيل الدخول بنجاح',
        'login_failed' => 'فشل في تسجيل الدخول',
        'phone_not_found' => 'رقم الهاتف غير موجود',
        'password_reset_otp_sent' => 'تم إرسال رمز التحقق لإعادة تعيين كلمة المرور بنجاح',
        'password_reset_successful' => 'تم إعادة تعيين كلمة المرور بنجاح',
        'password_reset_failed' => 'فشل في إعادة تعيين كلمة المرور',
        'user_not_found' => 'المستخدم غير موجود',
        'logout_successful' => 'تم تسجيل الخروج بنجاح',
        'logout_failed' => 'فشل في تسجيل الخروج',
        'profile_fetch_failed' => 'فشل في جلب الملف الشخصي',
        'logout_all_successful' => 'تم تسجيل الخروج من جميع الأجهزة بنجاح',
        'logout_all_failed' => 'فشل في تسجيل الخروج من جميع الأجهزة',
        'forgot_password_failed' => 'فشل في عملية نسيان كلمة المرور',
    ],

    'plan' => [
        'navigation' => [
            'label' => 'خطة',
            'plural_label' => 'الخطط',
            'group' => 'النظام',
        ],
        'sections' => [
            'basic_info' => 'المعلومات الأساسية',
            'media' => 'الوسائط',
            'statistics' => 'الإحصائيات',
            'timestamps' => 'الطوابع الزمنية',
        ],
        'fields' => [
            'name' => 'اسم الخطة',
            'price' => 'السعر',
            'duration_months' => 'المدة (بالأشهر)',
            'months' => 'أشهر',
            'description' => 'الوصف',
            'number_of_posts' => 'عدد المنشورات',
            'feature_posts' => 'ميزات المنشورات',
            'is_active' => 'الحالة النشطة',
            'avatar' => 'صورة الخطة',
            'total_subscriptions' => 'إجمالي الاشتراكات',
            'active_subscriptions' => 'الاشتراكات النشطة',
        ],
        'helpers' => [
            'duration_months' => 'عدد الأشهر التي تكون فيها هذه الخطة صالحة',
            'number_of_posts' => 'عدد المنشورات المسموح بها لهذه الخطة',
            'feature_posts' => 'وصف الميزات المدرجة في هذه الخطة',
            'is_active' => 'يمكن للمستخدمين الاشتراك في الخطط النشطة فقط',
            'avatar' => 'رفع صورة الخطة (الحجم المستحسن: 300×300 بكسل)',
        ],
        'table' => [
            'columns' => [
                'avatar' => 'الصورة',
                'name' => 'الاسم',
                'price' => 'السعر',
                'duration_months' => 'المدة',
                'months' => 'أشهر',
                'description' => 'الوصف',
                'number_of_posts' => 'حد المنشورات',
                'feature_posts' => 'الميزات',
                'active_subscriptions' => 'الاشتراكات النشطة',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
            ],
        ],
        'filters' => [
            'is_active' => 'الحالة النشطة',
        ],
        'infolist' => [
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'آخر تحديث',
        ],
        'pages' => [
            'view' => [
                'title' => 'عرض :name',
            ],
        ],
        'relations' => [
            'user_plans' => [
                'title' => 'اشتراكات الخطة',
                'description' => 'المستخدمون الذين اشتركوا في هذه الخطة',
                'user_avatar' => 'الصورة الشخصية',
                'user' => 'المستخدم',
                'user_email' => 'البريد الإلكتروني',
                'status' => 'الحالة',
                'starts_at' => 'يبدأ في',
                'ends_at' => 'ينتهي في',
                'cancelled_at' => 'تم إلغاؤه في',
                'subscribed_at' => 'تاريخ الاشتراك',
                'statuses' => [
                    'active' => 'نشط',
                    'cancelled' => 'ملغى',
                    'expired' => 'منتهي الصلاحية',
                ],
                'filters' => [
                    'status' => 'الحالة',
                ],
            ],
        ],
    ],

    'voucher' => [
        'navigation' => [
            'label' => 'كرت',
            'plural_label' => 'الكروت',
            'group' => 'النظام',
        ],
        'sections' => [
            'basic_info' => 'المعلومات الأساسية',
            'media' => 'الوسائط',
            'statistics' => 'الإحصائيات',
            'timestamps' => 'الطوابع الزمنية',
        ],
        'fields' => [
            'name' => 'اسم القسيمة',
            'avatar' => 'صورة القسيمة',
            'is_active' => 'الحالة النشطة',
            'price' => 'السعر',
            'total_stock' => 'إجمالي المخزون',
            'available_stock' => 'المخزون المتاح',
        ],
        'helpers' => [
            'name' => 'اسم فريد لنوع القسيمة',
            'avatar' => 'رفع صورة القسيمة (الحجم المستحسن: 300×300 بكسل)',
            'is_active' => 'ما إذا كان نوع القسيمة هذا نشطاً ومتاحاً للاستخدام',
            'price' => 'القيمة النقدية لهذه القسيمة',
        ],
        'table' => [
            'columns' => [
                'avatar' => 'الصورة',
                'name' => 'الاسم',
                'price' => 'السعر',
                'total_stock' => 'إجمالي المخزون',
                'available_stock' => 'المخزون المتاح',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
        ],
        'filters' => [
            'is_active' => 'الحالة النشطة',
            'trashed' => 'تضمين المحذوفة',
        ],
        'infolist' => [
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'آخر تحديث',
            'deleted_at' => 'تاريخ الحذف',
        ],
        'pages' => [
            'view' => [
                'title' => 'عرض القسيمة :name',
            ],
        ],
        'actions' => [
            'mark_as_active' => 'تحديد كنشطة',
            'mark_as_inactive' => 'تحديد كغير نشطة',
        ],
        'notifications' => [
            'marked_as_active' => 'تم تحديد القسيمة كنشطة بنجاح.',
            'marked_as_inactive' => 'تم تحديد القسيمة كغير نشطة بنجاح.',
        ],
    ],

    'voucher_stock' => [
        'navigation' => [
            'label' => 'مخزون الكروت',
            'plural_label' => 'مخزون الكروت',
            'singular_label' => 'مخزون القسيمة',
            'group' => 'الكروت',
        ],
        'relations' => [
            'title' => 'مخزون الكروت',
            'description' => 'أكواد الكروت الفردية القابلة للاستخدام لهذا النوع من الكروت',
        ],
        'fields' => [
            'id' => 'ر.م',
            'voucher' => 'القسيمة',
            'pin' => 'كود PIN',
            'used' => 'حالة الاستخدام',
            'used_at' => 'تاريخ الاستخدام',
            'quantity' => 'الكمية',
            'created_at' => 'تاريخ الإنشاء',
            'updated_at' => 'تاريخ التحديث',
            'deleted_at' => 'تاريخ الحذف',
        ],
        'helpers' => [
            'pin' => 'كود PIN فريد مكون من 12 رقم يتم إنشاؤه تلقائياً',
            'quantity' => 'عدد عناصر مخزون الكروت المراد إنشاؤها',
        ],
        'actions' => [
            'create' => 'إضافة مخزون',
            'bulk_create' => 'إنشاء جماعي',
            'generate' => 'إنشاء PIN جديد',
            'generate_pin' => 'إنشاء PIN',
            'pin_copied' => 'تم نسخ PIN إلى الحافظة!',
            'view' => 'عرض',
            'edit' => 'تعديل',
            'delete' => 'حذف',
            'force_delete' => 'حذف نهائي',
            'restore' => 'استعادة',
        ],
        'filters' => [
            'used' => 'حالة الاستخدام',
            'trashed' => 'تضمين المحذوفة',
        ],
        'notifications' => [
            'bulk_created' => 'تم إنشاء عناصر مخزون الكروت بنجاح!',
            'created' => 'تم إنشاء مخزون القسيمة بنجاح!',
            'created_body' => 'تم إنشاء مخزون القسيمة برقم PIN :pin للقسيمة :voucher.',
            'create_error' => 'فشل في إنشاء مخزون القسيمة',
            'create_error_body' => 'خطأ: :error',
            'bulk_created_body' => 'تم إنشاء :quantity عنصر مخزون قسائم للقسيمة :voucher.',
            'bulk_create_error' => 'فشل في إنشاء عناصر مخزون الكروت',
            'bulk_create_error_body' => 'خطأ: :error',
            'pin_generated' => 'تم إنشاء PIN بنجاح!',
            'pin_generated_body' => 'تم إنشاء PIN جديد :pin.',
        ],
        'confirmations' => [
            'toggle_active_title' => 'تغيير الحالة النشطة',
            'toggle_active_description' => 'هل أنت متأكد من أنك تريد تغيير الحالة النشطة لهذه القسيمة؟ سيؤثر هذا على توفرها.',
        ],
        'form' => [
            'section' => [
                'basic' => 'المعلومات الأساسية',
                'basic_description' => 'أدخل معلومات مخزون القسيمة',
            ],
        ],
        'table' => [
            'heading' => 'مخزون الكروت',
            'description' => 'إدارة أكواد الكروت الفردية وحالة استخدامها',
        ],
        'infolist' => [
            'section' => [
                'basic' => 'معلومات مخزون القسيمة',
                'basic_description' => 'تفاصيل عن عنصر مخزون القسيمة هذا',
                'timestamps' => 'الطوابع الزمنية',
                'timestamps_description' => 'تواريخ الإنشاء والتعديل',
            ],
        ],
        'placeholders' => [
            'select_voucher' => 'اختر قسيمة',
        ],
        'errors' => [
            'voucher_required' => 'القسيمة مطلوبة.',
        ],
    ],

    'plans' => [
        'active_plan_exists' => 'لديك خطة نشطة سيتم إلغاؤها.',
        'subscription_successful' => 'تم الاشتراك في الخطة بنجاح.',
        'subscription_failed' => 'فشل في الاشتراك في الخطة.',
        'no_active_plan' => 'ليس لديك خطة نشطة.',
        'cancellation_successful' => 'تم إلغاء الخطة بنجاح.',
        'cancellation_failed' => 'فشل في إلغاء الخطة.',
        'plan_active' => 'لديك خطة نشطة.',
        'confirmation_required' => 'يرجى التأكيد إذا كنت تريد إلغاء خطتك الحالية والاشتراك في الخطة الجديدة.',
        'plan_expired' => 'انتهت صلاحية خطتك.',
        'invalid_plan' => 'الخطة المحددة غير صحيحة.',
        'already_subscribed' => 'أنت مشترك بالفعل في هذه الخطة.',
    ],

    'department' => [
        'navigation' => [
            'label' => 'قسم',
            'plural' => 'الأقسام',
            'singular' => 'قسم',
        ],
        'form' => [
            'section' => [
                'basic' => 'المعلومات الأساسية',
                'basic_description' => 'أدخل المعلومات الأساسية للقسم',
                'media' => 'الوسائط',
                'media_description' => 'رفع صورة القسم',
            ],
            'fields' => [
                'name' => 'اسم القسم',
                'description' => 'الوصف',
                'is_active' => 'الحالة النشطة',
                'photo' => 'صورة القسم',
                'photo_help' => 'رفع صورة القسم (الحجم المستحسن: 300×300 بكسل)',
            ],
        ],
        'table' => [
            'columns' => [
                'photo' => 'الصورة',
                'name' => 'الاسم',
                'description' => 'الوصف',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
            ],
            'filters' => [
                'is_active' => 'الحالة النشطة',
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ],
        ],
        'infolist' => [
            'section' => [
                'basic' => 'معلومات القسم',
                'basic_description' => 'تفاصيل القسم وحالته',
            ],
            'fields' => [
                'photo' => 'الصورة',
                'name' => 'الاسم',
                'description' => 'الوصف',
                'is_active' => 'الحالة',
                'id' => 'معرف القسم',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'آخر تحديث',
            ],
            'status' => [
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ],
            'copy_message' => 'تم نسخ معرف القسم إلى الحافظة!',
        ],
        'pages' => [
            'view' => [
                'title' => 'عرض :name',
            ],
        ],
    ],

    'lyd' => 'د.ل',

    'city' => [
        'navigation' => [
            'label' => 'مدينة',
            'plural' => 'المدن',
            'singular' => 'مدينة',
        ],
        'form' => [
            'section' => [
                'basic' => 'المعلومات الأساسية',
                'basic_description' => 'أدخل المعلومات الأساسية للمدينة',
            ],
            'fields' => [
                'name' => 'اسم المدينة',
                'is_active' => 'الحالة النشطة',
            ],
        ],
        'table' => [
            'columns' => [
                'name' => 'الاسم',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
            'filters' => [
                'is_active' => 'الحالة النشطة',
                'active' => 'نشط',
                'inactive' => 'غير نشط',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'المدن',
            ],
            'create' => [
                'title' => 'إنشاء مدينة',
            ],
            'edit' => [
                'title' => 'تعديل المدينة',
            ],
        ],
    ],

    'post' => [
        'navigation' => [
            'label' => 'منشور',
            'plural' => 'المنشورات',
            'singular' => 'منشور',
        ],
        'form' => [
            'section' => [
                'basic' => 'المعلومات الأساسية',
                'basic_description' => 'أدخل المعلومات الأساسية للمنشور',
                'location' => 'تفاصيل الموقع',
                'location_description' => 'حدد الموقع ومعلومات الاتصال',
                'pricing' => 'معلومات التسعير',
                'pricing_description' => 'حدد السعر والعملة',
                'media' => 'الصور',
                'media_description' => 'رفع صور المنشور',
                'settings' => 'الإعدادات',
                'settings_description' => 'تكوين حالة المنشور والعلامات',
            ],
            'fields' => [
                'department_id' => 'القسم',
                'company' => 'الشركة',
                'city_id' => 'المدينة',
                'country_id' => 'البلد',
                'address' => 'العنوان',
                'activity' => 'النشاط',
                'phone' => 'الهاتف',
                'description' => 'الوصف',
                'price' => 'السعر',
                'currency' => 'العملة',
                'user_id' => 'المستخدم',
                'status' => 'الحالة',
                'tags' => 'العلامات (الوسوم)',
                'images' => 'الصور',
                'number_of_views' => 'المشاهدات',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'المعرف',
                'department' => 'القسم',
                'company' => 'الشركة',
                'city' => 'المدينة',
                'country' => 'البلد',
                'activity' => 'النشاط',
                'phone' => 'الهاتف',
                'description' => 'الوصف',
                'price' => 'السعر',
                'currency' => 'العملة',
                'status' => 'الحالة',
                'user' => 'المستخدم',
                'number_of_views' => 'المشاهدات',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
            'filters' => [
                'department' => 'القسم',
                'city' => 'المدينة',
                'country' => 'البلد',
                'status' => 'الحالة',
                'currency' => 'العملة',
            ],
        ],
        'status' => [
            'draft' => 'مسودة',
            'published' => 'منشور',
            'archived' => 'مؤرشف',
        ],
        'currency' => [
            'د.ل' => 'دينار ليبي',
            'دولار' => 'دولار أمريكي',
            'يورو' => 'يورو',
            'lyds' => 'دينار ليبي',
            'usd' => 'دولار أمريكي',
            'eur' => 'يورو',
        ],
        'infolist' => [
            'section' => [
                'basic' => 'معلومات المنشور',
                'basic_description' => 'التفاصيل الرئيسية والوصف للمنشور',
                'details' => 'التفاصيل الإضافية',
                'details_description' => 'معلومات الشركة والموقع والعلامات والتواريخ',
            ],
            'fields' => [
                'id' => 'معرف المنشور',
                'images' => 'الصور',
                'description' => 'الوصف',
                'status' => 'الحالة',
                'number_of_views' => 'المشاهدات',
                'price' => 'السعر',
                'department' => 'القسم',
                'company' => 'الشركة',
                'activity' => 'النشاط',
                'user' => 'نُشر بواسطة',
                'country' => 'البلد',
                'city' => 'المدينة',
                'address' => 'العنوان',
                'phone' => 'الهاتف',
                'tags' => 'العلامات (الوسوم)',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
                'deleted_at' => 'تاريخ الحذف',
            ],
            'placeholders' => [
                'company' => 'لم يتم تحديد الشركة',
                'activity' => 'لم يتم تحديد النشاط',
                'city' => 'لم يتم تحديد المدينة',
                'address' => 'لم يتم توفير العنوان',
                'phone' => 'لا يوجد رقم هاتف',
                'tags' => 'لم يتم إضافة علامات',
                'not_deleted' => 'غير محذوف',
            ],
            'copy_message' => 'تم نسخ معرف المنشور إلى الحافظة!',
            'copy_phone' => 'تم نسخ رقم الهاتف!',
        ],
        'pages' => [
            'list' => [
                'title' => 'المنشورات',
            ],
            'create' => [
                'title' => 'إنشاء منشور',
            ],
            'edit' => [
                'title' => 'تعديل المنشور',
            ],
            'view' => [
                'title' => 'عرض المنشور',
            ],
        ],
    ],

    'comment' => [
        'navigation' => [
            'singular' => 'تعليق',
            'plural' => 'التعليقات',
        ],
        'relations' => [
            'title' => 'التعليقات',
        ],
        'form' => [
            'user' => 'المستخدم',
            'comment' => 'التعليق',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'user' => 'المستخدم',
                'comment' => 'التعليق',
                'deleted' => 'محذوف',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
            ],
        ],
        'actions' => [
            'create' => 'إضافة تعليق',
            'edit' => 'تعديل التعليق',
            'delete' => 'حذف التعليق',
        ],
        'modal' => [
            'create' => [
                'heading' => 'إضافة تعليق جديد',
                'submit' => 'إضافة التعليق',
                'cancel' => 'إلغاء',
            ],
            'edit' => [
                'heading' => 'تعديل التعليق',
                'submit' => 'حفظ التغييرات',
                'cancel' => 'إلغاء',
            ],
            'delete' => [
                'heading' => 'حذف التعليق',
                'description' => 'هل أنت متأكد من أنك تريد حذف هذا التعليق؟ لا يمكن التراجع عن هذا الإجراء.',
                'submit' => 'حذف',
                'cancel' => 'إلغاء',
            ],
        ],
    ],

    'like' => [
        'navigation' => [
            'singular' => 'إعجاب',
            'plural' => 'الإعجابات',
        ],
        'relations' => [
            'title' => 'الإعجابات',
        ],
        'form' => [
            'user' => 'المستخدم',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'user' => 'المستخدم',
                'email' => 'البريد الإلكتروني',
                'created_at' => 'تاريخ الإعجاب',
            ],
        ],
    ],

    'country' => [
        'navigation' => [
            'singular' => 'دولة',
            'plural' => 'الدول',
        ],
        'sections' => [
            'basic_info' => 'المعلومات الأساسية',
            'timestamps' => 'الطوابع الزمنية',
        ],
        'fields' => [
            'name' => 'اسم الدولة',
            'name_helper' => 'أدخل الاسم الكامل للدولة',
            'iso' => 'الرمز الدولي',
            'iso_helper' => 'أدخل الرمز الدولي المكون من 3 أحرف (مثل: USA، GBR)',
            'users_count' => 'عدد المستخدمين',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'name' => 'الاسم',
                'iso' => 'الرمز الدولي',
                'users_count' => 'المستخدمون',
            ],
            'filters' => [
                'has_users' => 'حالة المستخدمين',
                'with_users' => 'مع مستخدمين',
                'without_users' => 'بدون مستخدمين',
            ],
            'empty' => [
                'heading' => 'لا توجد دول',
                'description' => 'ابدأ بإنشاء أول دولة.',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'الدول',
            ],
            'create' => [
                'title' => 'إضافة دولة',
            ],
            'edit' => [
                'title' => 'تعديل الدولة',
            ],
            'view' => [
                'title' => 'عرض الدولة',
            ],
        ],
    ],

    'complaint' => [
        'navigation' => [
            'label' => 'شكوى',
            'plural_label' => 'الشكاوى',
            'group' => 'دعم العملاء',
        ],
        'status' => [
            'open' => 'مفتوحة',
            'resolved' => 'محلولة',
        ],
        'fields' => [
            'body' => 'تفاصيل الشكوى',
            'body_placeholder' => 'أدخل تفاصيل الشكوى...',
            'user' => 'العميل',
            'status' => 'الحالة',
            'created_at' => 'تاريخ الإرسال',
            'updated_at' => 'تاريخ التحديث',
        ],
        'sections' => [
            'basic_info' => 'معلومات الشكوى',
            'customer_info' => 'معلومات العميل',
            'timestamps' => 'الطوابع الزمنية',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'body' => 'الشكوى',
                'user' => 'العميل',
                'user_email' => 'بريد العميل الإلكتروني',
                'status' => 'الحالة',
                'created_at' => 'تاريخ الإرسال',
                'updated_at' => 'تاريخ التحديث',
            ],
            'filters' => [
                'status' => 'الحالة',
                'open' => 'مفتوحة',
                'resolved' => 'محلولة',
            ],
            'actions' => [
                'mark_resolved' => 'تحديد كمحلولة',
                'mark_open' => 'تحديد كمفتوحة',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'الشكاوى',
            ],
            'create' => [
                'title' => 'إنشاء شكوى',
            ],
            'edit' => [
                'title' => 'تعديل الشكوى',
            ],
            'view' => [
                'title' => 'عرض الشكوى',
            ],
        ],
    ],

    'offensive_word' => [
        'navigation' => [
            'label' => 'كلمة مسيئة',
            'plural_label' => 'الكلمات المسيئة',
            'group' => 'النظام',
        ],
        'severity' => [
            'high' => 'عالية',
            'medium' => 'متوسطة',
            'low' => 'منخفضة',
        ],
        'status' => [
            'active' => 'نشط',
            'inactive' => 'غير نشط',
        ],
        'fields' => [
            'word' => 'الكلمة',
            'description' => 'الوصف',
            'severity' => 'مستوى الخطورة',
            'is_active' => 'الحالة النشطة',
        ],
        'sections' => [
            'basic_info' => 'معلومات الكلمة',
            'settings' => 'الإعدادات',
        ],
        'table' => [
            'columns' => [
                'id' => 'ر.م',
                'word' => 'الكلمة',
                'description' => 'الوصف',
                'severity' => 'مستوى الخطورة',
                'is_active' => 'نشط',
                'created_at' => 'تاريخ الإنشاء',
                'updated_at' => 'تاريخ التحديث',
            ],
            'filters' => [
                'severity' => 'مستوى الخطورة',
                'is_active' => 'الحالة النشطة',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'الكلمات المسيئة',
            ],
            'create' => [
                'title' => 'إنشاء كلمة مسيئة',
            ],
            'edit' => [
                'title' => 'تعديل الكلمة المسيئة',
            ],
            'view' => [
                'title' => 'عرض الكلمة المسيئة',
            ],
        ],
        'actions' => [
            'create' => 'إنشاء كلمة مسيئة',
            'edit' => 'تعديل الكلمة المسيئة',
        ],
        'modals' => [
            'create' => [
                'description' => 'إضافة كلمة مسيئة جديدة إلى النظام.',
            ],
            'edit' => [
                'description' => 'تعديل تفاصيل الكلمة المسيئة.',
            ],
        ],
    ],

    'navigation' => [
        'groups' => [
            'content' => 'المحتوى',
            'customer_support' => 'دعم العملاء',
            'settings' => 'الإعدادات',
        ],
    ],
];