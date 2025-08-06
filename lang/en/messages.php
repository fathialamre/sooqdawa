<?php

return [
    'common' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'all' => 'All',
        'yes' => 'Yes',
        'no' => 'No',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'view' => 'View',
        'create' => 'Create',
        'actions' => 'Actions',
        'loading' => 'Loading...',
        'search' => 'Search',
        'filter' => 'Filter',
        'reset' => 'Reset',
    ],

    'navigation' => [
        'groups' => [
            'administration' => 'Administration',
            'user_management' => 'User Management',
            'system' => 'System',
            'content' => 'Content',
        ],
    ],

    'saved_post' => [
        'navigation' => [
            'label' => 'Saved Post',
            'plural_label' => 'Saved Posts',
            'group' => 'Content',
        ],
        'form' => [
            'section' => [
                'basic' => [
                    'title' => 'Basic Information',
                    'description' => 'Select the user and post for this saved post entry',
                ],
            ],
            'fields' => [
                'user' => 'User',
                'post' => 'Post',
            ],
            'placeholders' => [
                'select_user' => 'Select a user',
                'select_post' => 'Select a post',
            ],
        ],
        'table' => [
            'columns' => [
                'user' => 'User',
                'post' => 'Post',
                'department' => 'Department',
                'price' => 'Price',
                'saved_at' => 'Saved At',
                'updated_at' => 'Updated At',
            ],
        ],
    ],

    'user_plan' => [
        'navigation' => [
            'label' => 'User Plan',
            'plural_label' => 'User Plans',
            'group' => 'Content',
        ],
        'form' => [
            'sections' => [
                'basic' => 'Basic Information',
                'dates' => 'Date Information',
            ],
            'fields' => [
                'user' => 'User',
                'plan' => 'Plan',
                'status' => 'Status',
                'starts_at' => 'Starts At',
                'ends_at' => 'Ends At',
                'expired_at' => 'Expired At',
                'is_expired' => 'Is Expired',
            ],
            'statuses' => [
                'active' => 'Active',
                'cancelled' => 'Cancelled',
                'expired' => 'Expired',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'user_name' => 'User Name',
                'user_email' => 'User Email',
                'plan_name' => 'Plan Name',
                'plan_price' => 'Plan Price',
                'status' => 'Status',
                'starts_at' => 'Starts At',
                'ends_at' => 'Ends At',
                'expired_at' => 'Expired At',
                'cancelled_at' => 'Cancelled At',
                'created_at' => 'Created At',
            ],
            'statuses' => [
                'active' => 'Active',
                'cancelled' => 'Cancelled',
                'expired' => 'Expired',
            ],
            'filters' => [
                'status' => 'Status',
                'active' => 'Active',
                'expired' => 'Expired',
                'by_user' => 'By User',
                'by_plan' => 'By Plan',
            ],
        ],
        'infolist' => [
            'user_information' => 'User Information',
            'plan_information' => 'Plan Information',
            'subscription_details' => 'Subscription Details',
            'timestamps' => 'Timestamps',
            'user_name' => 'User Name',
            'user_email' => 'User Email',
            'user_phone' => 'User Phone',
            'user_country' => 'User Country',
            'plan_name' => 'Plan Name',
            'plan_price' => 'Plan Price',
            'plan_duration' => 'Plan Duration',
            'plan_posts' => 'Plan Posts',
            'status' => 'Status',
            'is_expired' => 'Is Expired',
            'starts_at' => 'Starts At',
            'ends_at' => 'Ends At',
            'expired_at' => 'Expired At',
            'cancelled_at' => 'Cancelled At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'months' => 'months',
            'statuses' => [
                'active' => 'Active',
                'cancelled' => 'Cancelled',
                'expired' => 'Expired',
            ],
        ],
        'actions' => [
            'add_plan' => 'Add Plan to User',
            'cancel' => [
                'label' => 'Cancel Plan',
                'modal' => [
                    'title' => 'Cancel User Plan',
                    'description' => 'Are you sure you want to cancel this user plan? This action cannot be undone.',
                    'confirm' => 'Yes, Cancel Plan',
                    'cancel' => 'No, Keep Plan',
                ],
                'notification' => [
                    'title' => 'Plan Cancelled',
                    'body' => 'The user plan has been cancelled successfully.',
                ],
            ],
            'create_modal' => [
                'title' => 'Create New User Plan',
                'description' => 'Assign a plan to a user. The plan will start immediately and any existing active plan will be cancelled.',
                'submit' => 'Create Plan',
                'cancel' => 'Cancel',
            ],
        ],
        'fields' => [
            'user' => 'User',
            'plan' => 'Plan',
            'immediate_activation' => 'Immediate Activation',
        ],
        'placeholders' => [
            'select_user' => 'Select a user',
            'select_plan' => 'Select a plan',
        ],
        'helpers' => [
            'plan_selection' => 'Choose an active plan to assign to the user. The plan duration will be automatically calculated based on the selected plan.',
            'immediate_activation' => 'Activate the plan immediately (any existing plan will be cancelled)',
        ],
        'errors' => [
            'user_required' => 'User is required',
            'plan_required' => 'Plan is required',
        ],
        'notifications' => [
            'plan_added' => 'Plan Added Successfully',
            'plan_added_body' => 'Plan :plan has been added to user :user for :duration',
            'add_error' => 'Error Adding Plan',
            'add_error_body' => 'Failed to add plan: :error',
        ],
        'months' => 'months',
    ],

    'banner' => [
        'navigation' => [
            'label' => 'Banner',
            'plural_label' => 'Banners',
            'group' => 'Content Management',
        ],
        'types' => [
            'post' => 'Post',
            'department' => 'Department',
            'external_link' => 'External Link',
            'none' => 'None',
        ],
        'fields' => [
            'type' => 'Type',
            'external_link' => 'External Link',
            'is_active' => 'Active',
            'banner_image' => 'Banner Image',
            'post' => 'Post',
            'department' => 'Department',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Settings',
                'basic_description' => 'Configure banner type and status',
                'image' => 'Banner Image',
                'image_description' => 'Upload the banner image with proper dimensions',
                'target' => 'Target Configuration',
                'target_description' => 'Configure where the banner should link to',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'banner_image' => 'Image',
                'type' => 'Type',
                'model' => 'Model Type',
                'model_id' => 'Model ID',
                'linked_to' => 'Linked To',
                'target' => 'Target',
                'external_link' => 'External Link',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
        ],
        'filters' => [
            'type' => 'Type',
            'is_active' => 'Status',
        ],
    ],

    'wallet' => [
        'navigation' => [
            'label' => 'Wallet',
            'plural_label' => 'Wallets',
            'group' => 'Financial',
        ],
        'fields' => [
            'user' => 'User',
            'voucher' => 'Voucher',
            'voucher_placeholder' => 'Select voucher (optional)',
            'credit' => 'Credit',
            'debit' => 'Debit',
            'balance' => 'Balance',
            'amount' => 'Amount',
            'description' => 'Description',
            'description_placeholder' => 'Enter transaction description...',
            'topup_description_placeholder' => 'Enter reason for wallet top-up (optional)...',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Information',
                'basic_description' => 'Select user and voucher for this transaction',
                'transaction' => 'Transaction Details',
                'transaction_description' => 'Enter credit, debit, and balance amounts',
                'details' => 'Additional Details',
                'details_description' => 'Add description and notes for this transaction',
            ],
            'helpers' => [
                'user_selection' => 'Select an active user to top up their wallet',
                'amount_range' => 'Enter amount between LYD0.01 and LYD10,000',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'user' => 'User',
                'credit' => 'Credit',
                'debit' => 'Debit',
                'balance' => 'Balance',
                'voucher' => 'Voucher',
                'description' => 'Description',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
        ],
        'filters' => [
            'user' => 'User',
            'voucher' => 'Voucher',
        ],
        'actions' => [
            'topup' => 'Top Up',
            'topup_wallet' => 'Top Up Wallet',
        ],
        'modals' => [
            'topup' => [
                'description' => 'Add credit to a user\'s wallet directly without using a voucher.',
            ],
        ],
        'notifications' => [
            'topup_success' => 'Wallet topped up successfully',
            'topup_success_body' => 'Successfully added ${amount} to {user}\'s wallet. New balance: ${balance}',
            'topup_error' => 'Failed to top up wallet',
            'topup_error_body' => 'An error occurred: {error}',
        ],
        'default_descriptions' => [
            'topup' => 'Wallet top-up: ${amount}',
        ],
    ],

    'user' => [
        'navigation' => [
            'label' => 'User',
            'plural_label' => 'Users',
            'group' => 'User Management',
        ],
        'sections' => [
            'basic_info' => 'Basic Information',
            'security' => 'Security',
            'media' => 'Media',
            'notifications' => 'Notifications',
        ],
        'fields' => [
            'name' => 'Full Name',
            'email' => 'Email Address',
            'type' => 'User Type',
            'country' => 'Country',
            'is_active' => 'Active Status',
            'password' => 'Password',
            'password_confirmation' => 'Confirm Password',
            'avatar' => 'Avatar',
            'fcm_token' => 'FCM Token',
        ],
        'helpers' => [
            'fcm_token' => 'Firebase Cloud Messaging token for push notifications',
        ],
        'types' => [
            'admin' => 'Administrator',
            'customer' => 'Customer',
            'company' => 'Company',
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'avatar' => 'Avatar',
                'name' => 'Name',
                'email' => 'Email',
                'type' => 'Type',
                'country' => 'Country',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
        ],
        'filters' => [
            'type' => 'User Type',
            'country' => 'Country',
            'is_active' => 'Active Status',
        ],
        'actions' => [
            'change_password' => 'Change Password',
            'block' => 'Block',
            'unblock' => 'Unblock',
            'block_user' => 'Block User',
            'unblock_user' => 'Unblock User',
        ],
        'modals' => [
            'change_password' => [
                'title' => 'Change User Password',
                'description' => 'Enter a new password for this user account.',
                'new_password' => 'New Password',
                'confirm_password' => 'Confirm New Password',
                'submit' => 'Change Password',
            ],
            'block' => [
                'description' => 'Are you sure you want to block :name? They will no longer be able to access the system.',
            ],
            'unblock' => [
                'description' => 'Are you sure you want to unblock :name? They will regain access to the system.',
            ],
        ],
        'notifications' => [
            'password_changed' => 'Password changed successfully',
            'user_blocked' => 'User :name has been blocked successfully',
            'user_unblocked' => 'User :name has been unblocked successfully',
        ],
        'infolist' => [
            'email_copied' => 'Email copied to clipboard',
            'no_country' => 'No country specified',
            'no_fcm_token' => 'No FCM token',
            'created_at' => 'Created Date',
            'updated_at' => 'Last Updated',
            'deleted_at' => 'Deleted Date',
            'not_deleted' => 'Not deleted',
            'email_verified' => 'Email Verified',
            'email_not_verified' => 'Email not verified',
            'password_status' => 'Password',
            'password_set' => 'Password is set',
        ],
        'pages' => [
            'view' => [
                'title' => 'View :name',
            ],
        ],
        'relations' => [
            'followers' => [
                'title' => 'Followers',
                'user' => 'User',
                'followed_at' => 'Followed At',
                'total_followers' => 'Total Followers',
            ],
            'following' => [
                'title' => 'Following',
                'user' => 'User',
                'followed_at' => 'Followed At',
                'total_following' => 'Total Following',
            ],
        ],
    ],

    'settings' => [
        'title' => 'Settings',
        'heading' => 'Application Settings',
        'navigation' => [
            'label' => 'Settings',
        ],
        'sections' => [
            'application_information' => 'Application Information',
            'application_information_description' => 'Basic application information and contact details',
            'application_logo' => 'Application Logo',
            'application_logo_description' => 'Upload application logo (preferred size: 300x300 pixels)',
        ],
        'fields' => [
            'app_name' => 'Application Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'full_address' => 'Full Address',
            'logo' => 'Logo',
            'logo_helper_text' => 'Maximum file size: 2 MB. Accepted formats: JPEG, PNG, GIF, WebP',
        ],
        'actions' => [
            'save' => 'Save Settings',
        ],
        'updated' => 'Settings Updated',
        'updated_description' => 'Application settings have been updated successfully.',
    ],

    'customer' => [
        'actions' => [
            'topup_wallet' => 'Top Up Wallet',
            'topup_wallet_description' => 'Add funds to customer wallet balance.',
            'topup_confirm' => 'Top Up Now',
        ],
        'fields' => [
            'amount' => 'Amount',
            'notes' => 'Notes',
        ],
        'helpers' => [
            'topup_amount' => 'Enter the top-up amount.',
            'topup_notes' => 'Enter top-up notes.',
        ],
        'notifications' => [
            'topup_initiated' => 'Top-up Initiated',
            'topup_amount' => ':amount has been added to the wallet',
        ],
    ],

    'auth' => [
        'otp_sent' => 'OTP sent successfully',
        'otp_generated' => 'OTP generated successfully',
        'otp_already_generated' => 'OTP already generated',
        'registration_failed' => 'Registration failed',
        'otp_expired' => 'OTP expired or not found',
        'invalid_otp' => 'Invalid OTP',
        'registration_successful' => 'Registration successful',
        'registration_verification_failed' => 'Registration verification failed',
        'invalid_credentials' => 'Invalid credentials provided',
        'login_successful' => 'Login successful',
        'login_failed' => 'Login failed',
        'phone_not_found' => 'Phone number not found',
        'password_reset_otp_sent' => 'Password reset OTP sent successfully',
        'password_reset_successful' => 'Password reset successful',
        'password_reset_failed' => 'Password reset failed',
        'user_not_found' => 'User not found',
        'logout_successful' => 'Logout successful',
        'logout_failed' => 'Logout failed',
        'profile_fetch_failed' => 'Profile fetch failed',
        'logout_all_successful' => 'Logout from all devices successful',
        'logout_all_failed' => 'Logout from all devices failed',
        'forgot_password_failed' => 'Forgot password process failed',
    ],

    'plan' => [
        'navigation' => [
            'label' => 'Plan',
            'plural_label' => 'Plans',
            'group' => 'System',
        ],
        'sections' => [
            'basic_info' => 'Basic Information',
            'media' => 'Media',
            'statistics' => 'Statistics',
            'timestamps' => 'Timestamps',
        ],
        'fields' => [
            'name' => 'Plan Name',
            'price' => 'Price',
            'duration_months' => 'Duration (Months)',
            'months' => 'months',
            'description' => 'Description',
            'number_of_posts' => 'Number of Posts',
            'feature_posts' => 'Feature Posts',
            'is_active' => 'Active Status',
            'avatar' => 'Plan Image',
            'total_subscriptions' => 'Total Subscriptions',
            'active_subscriptions' => 'Active Subscriptions',
        ],
        'helpers' => [
            'duration_months' => 'Number of months this plan is valid for',
            'number_of_posts' => 'Number of posts allowed for this plan',
            'feature_posts' => 'Description of features included in this plan',
            'is_active' => 'Only active plans can be subscribed to by users',
            'avatar' => 'Upload a plan image (recommended size: 300x300 pixels)',
        ],
        'table' => [
            'columns' => [
                'avatar' => 'Image',
                'name' => 'Name',
                'price' => 'Price',
                'duration_months' => 'Duration',
                'months' => 'months',
                'description' => 'Description',
                'number_of_posts' => 'Posts Limit',
                'feature_posts' => 'Features',
                'active_subscriptions' => 'Active Subscriptions',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],
        ],
        'filters' => [
            'is_active' => 'Active Status',
        ],
        'infolist' => [
            'created_at' => 'Created Date',
            'updated_at' => 'Last Updated',
        ],
        'pages' => [
            'view' => [
                'title' => 'View :name',
            ],
        ],
        'relations' => [
            'user_plans' => [
                'title' => 'Plan Subscriptions',
                'description' => 'Users who have subscribed to this plan',
                'user_avatar' => 'Avatar',
                'user' => 'User',
                'user_email' => 'Email',
                'status' => 'Status',
                'starts_at' => 'Starts At',
                'ends_at' => 'Ends At',
                'cancelled_at' => 'Cancelled At',
                'subscribed_at' => 'Subscribed At',
                'statuses' => [
                    'active' => 'Active',
                    'cancelled' => 'Cancelled',
                    'expired' => 'Expired',
                ],
                'filters' => [
                    'status' => 'Status',
                ],
            ],
        ],
    ],

    'voucher' => [
        'navigation' => [
            'label' => 'Voucher',
            'plural_label' => 'Vouchers',
            'group' => 'System',
        ],
        'sections' => [
            'basic_info' => 'Basic Information',
            'media' => 'Media',
            'statistics' => 'Statistics',
            'timestamps' => 'Timestamps',
        ],
        'fields' => [
            'name' => 'Voucher Name',
            'avatar' => 'Voucher Image',
            'is_active' => 'Active Status',
            'price' => 'Price',
            'total_stock' => 'Total Stock',
            'available_stock' => 'Available Stock',
        ],
        'helpers' => [
            'name' => 'Unique name for the voucher type',
            'avatar' => 'Upload a voucher image (recommended size: 300x300 pixels)',
            'is_active' => 'Whether this voucher type is active and available for use',
            'price' => 'The monetary value of this voucher',
        ],
        'table' => [
            'columns' => [
                'avatar' => 'Image',
                'name' => 'Name',
                'price' => 'Price',
                'total_stock' => 'Total Stock',
                'available_stock' => 'Available Stock',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
        ],
        'filters' => [
            'is_active' => 'Active Status',
            'trashed' => 'Include Deleted',
        ],
        'infolist' => [
            'created_at' => 'Created Date',
            'updated_at' => 'Last Updated',
            'deleted_at' => 'Deleted Date',
        ],
        'pages' => [
            'view' => [
                'title' => 'View Voucher :name',
            ],
        ],
        'actions' => [
            'mark_as_active' => 'Mark as Active',
            'mark_as_inactive' => 'Mark as Inactive',
        ],
        'notifications' => [
            'marked_as_active' => 'Voucher marked as active successfully.',
            'marked_as_inactive' => 'Voucher marked as inactive successfully.',
        ],
    ],

    'voucher_stock' => [
        'navigation' => [
            'label' => 'Voucher Stock',
            'plural_label' => 'Voucher Stocks',
            'singular_label' => 'Voucher Stock',
            'group' => 'Vouchers',
        ],
        'relations' => [
            'title' => 'Voucher Stock',
            'description' => 'Individual redeemable voucher codes for this voucher type',
        ],
        'fields' => [
            'id' => 'ID',
            'voucher' => 'Voucher',
            'pin' => 'PIN Code',
            'used' => 'Used Status',
            'used_at' => 'Used At',
            'quantity' => 'Quantity',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ],
        'helpers' => [
            'pin' => 'Auto-generated unique 12-digit PIN code',
            'quantity' => 'Number of voucher stock items to create',
        ],
        'actions' => [
            'create' => 'Add Stock',
            'bulk_create' => 'Bulk Create',
            'generate' => 'Generate New PIN',
            'generate_pin' => 'Generate PIN',
            'pin_copied' => 'PIN copied to clipboard!',
            'view' => 'View',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'force_delete' => 'Force Delete',
            'restore' => 'Restore',
        ],
        'filters' => [
            'used' => 'Used Status',
            'trashed' => 'Include Deleted',
        ],
        'notifications' => [
            'bulk_created' => 'Voucher stock items created successfully!',
            'created' => 'Voucher stock created successfully!',
            'created_body' => 'Voucher stock with PIN :pin for voucher :voucher has been created.',
            'create_error' => 'Failed to create voucher stock',
            'create_error_body' => 'Error: :error',
            'bulk_created_body' => ':quantity voucher stock items created for voucher :voucher.',
            'bulk_create_error' => 'Failed to create voucher stock items',
            'bulk_create_error_body' => 'Error: :error',
            'pin_generated' => 'PIN generated successfully!',
            'pin_generated_body' => 'New PIN :pin has been generated.',
        ],
        'confirmations' => [
            'toggle_active_title' => 'Toggle Active Status',
            'toggle_active_description' => 'Are you sure you want to change the active status of this voucher? This will affect its availability.',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Information',
                'basic_description' => 'Enter the voucher stock information',
            ],
        ],
        'table' => [
            'heading' => 'Voucher Stocks',
            'description' => 'Manage individual voucher codes and their usage status',
        ],
        'infolist' => [
            'section' => [
                'basic' => 'Voucher Stock Information',
                'basic_description' => 'Details about this voucher stock item',
                'timestamps' => 'Timestamps',
                'timestamps_description' => 'Creation and modification dates',
            ],
        ],
        'placeholders' => [
            'select_voucher' => 'Select a voucher',
        ],
        'errors' => [
            'voucher_required' => 'Voucher is required.',
        ],
    ],

    'plans' => [
        'active_plan_exists' => 'You have an active plan that will be cancelled.',
        'subscription_successful' => 'Successfully subscribed to the plan.',
        'subscription_failed' => 'Failed to subscribe to the plan.',
        'no_active_plan' => 'You don\'t have an active plan.',
        'cancellation_successful' => 'Plan cancelled successfully.',
        'cancellation_failed' => 'Failed to cancel the plan.',
        'plan_active' => 'You have an active plan.',
        'confirmation_required' => 'Please confirm if you want to cancel your current plan and subscribe to the new one.',
        'plan_expired' => 'Your plan has expired.',
        'invalid_plan' => 'Invalid plan selected.',
        'already_subscribed' => 'You are already subscribed to this plan.',
    ],

    'department' => [
        'navigation' => [
            'label' => 'Department',
            'plural' => 'Departments',
            'singular' => 'Department',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Information',
                'basic_description' => 'Enter the basic department information',
                'media' => 'Media',
                'media_description' => 'Upload department image',
            ],
            'fields' => [
                'name' => 'Department Name',
                'description' => 'Description',
                'is_active' => 'Active Status',
                'photo' => 'Department Photo',
                'photo_help' => 'Upload a department image (recommended size: 300x300 pixels)',
            ],
        ],
        'table' => [
            'columns' => [
                'photo' => 'Photo',
                'name' => 'Name',
                'description' => 'Description',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],
            'filters' => [
                'is_active' => 'Active Status',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'infolist' => [
            'section' => [
                'basic' => 'Department Information',
                'basic_description' => 'Department details and status',
            ],
            'fields' => [
                'photo' => 'Photo',
                'name' => 'Name',
                'description' => 'Description',
                'is_active' => 'Status',
                'id' => 'Department ID',
                'created_at' => 'Created Date',
                'updated_at' => 'Last Updated',
            ],
            'status' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
            'copy_message' => 'Department ID copied to clipboard!',
        ],
        'pages' => [
            'view' => [
                'title' => 'View :name',
            ],
        ],
    ],

    'lyd' => 'LYD',

    'city' => [
        'navigation' => [
            'label' => 'City',
            'plural' => 'Cities',
            'singular' => 'City',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Information',
                'basic_description' => 'Enter the basic city information',
            ],
            'fields' => [
                'name' => 'City Name',
                'is_active' => 'Active Status',
            ],
        ],
        'table' => [
            'columns' => [
                'name' => 'Name',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
            'filters' => [
                'is_active' => 'Active Status',
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'Cities',
            ],
            'create' => [
                'title' => 'Create City',
            ],
            'edit' => [
                'title' => 'Edit City',
            ],
        ],
    ],

    'post' => [
        'navigation' => [
            'label' => 'Post',
            'plural' => 'Posts',
            'singular' => 'Post',
        ],
        'form' => [
            'section' => [
                'basic' => 'Basic Information',
                'basic_description' => 'Enter the basic post information',
                'location' => 'Location Details',
                'location_description' => 'Specify the location and contact information',
                'pricing' => 'Pricing Information',
                'pricing_description' => 'Set the price and currency',
                'media' => 'Images',
                'media_description' => 'Upload post images',
                'settings' => 'Settings',
                'settings_description' => 'Configure post status and tags',
            ],
            'fields' => [
                'department_id' => 'Department',
                'company' => 'Company',
                'city_id' => 'City',
                'country_id' => 'Country',
                'address' => 'Address',
                'activity' => 'Activity',
                'phone' => 'Phone',
                'description' => 'Description',
                'price' => 'Price',
                'currency' => 'Currency',
                'user_id' => 'User',
                'status' => 'Status',
                'tags' => 'Tags',
                'images' => 'Images',
                'number_of_views' => 'Views',
            ],
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'department' => 'Department',
                'company' => 'Company',
                'city' => 'City',
                'country' => 'Country',
                'activity' => 'Activity',
                'phone' => 'Phone',
                'description' => 'Description',
                'price' => 'Price',
                'currency' => 'Currency',
                'status' => 'Status',
                'user' => 'User',
                'number_of_views' => 'Views',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'deleted_at' => 'Deleted At',
            ],
            'filters' => [
                'department' => 'Department',
                'city' => 'City',
                'country' => 'Country',
                'status' => 'Status',
                'currency' => 'Currency',
            ],
        ],
        'status' => [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ],
        'currency' => [
            'د.ل' => 'Libyan Dinar',
            'دولار' => 'US Dollar',
            'يورو' => 'Euro',
            'lyds' => 'Libyan Dinar',
            'usd' => 'US Dollar',
            'eur' => 'Euro',
        ],
        'infolist' => [
            'section' => [
                'basic' => 'Post Information',
                'basic_description' => 'Main post details and description',
                'details' => 'Additional Details',
                'details_description' => 'Company information, location, tags, and timestamps',
            ],
            'fields' => [
                'id' => 'Post ID',
                'images' => 'Images',
                'description' => 'Description',
                'status' => 'Status',
                'number_of_views' => 'Views',
                'price' => 'Price',
                'department' => 'Department',
                'company' => 'Company',
                'activity' => 'Activity',
                'user' => 'Posted By',
                'country' => 'Country',
                'city' => 'City',
                'address' => 'Address',
                'phone' => 'Phone',
                'tags' => 'Tags',
                'created_at' => 'Created',
                'updated_at' => 'Updated',
                'deleted_at' => 'Deleted',
            ],
            'placeholders' => [
                'company' => 'No company specified',
                'activity' => 'No activity specified',
                'city' => 'No city specified',
                'address' => 'No address provided',
                'phone' => 'No phone number',
                'tags' => 'No tags added',
                'not_deleted' => 'Not deleted',
            ],
            'copy_message' => 'Post ID copied to clipboard!',
            'copy_phone' => 'Phone number copied!',
        ],
        'pages' => [
            'list' => [
                'title' => 'Posts',
            ],
            'create' => [
                'title' => 'Create Post',
            ],
            'edit' => [
                'title' => 'Edit Post',
            ],
            'view' => [
                'title' => 'View Post',
            ],
        ],
    ],

    'comment' => [
        'navigation' => [
            'singular' => 'Comment',
            'plural' => 'Comments',
        ],
        'relations' => [
            'title' => 'Comments',
        ],
        'form' => [
            'user' => 'User',
            'comment' => 'Comment',
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'user' => 'User',
                'comment' => 'Comment',
                'deleted' => 'Deleted',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],
        ],
        'actions' => [
            'create' => 'Add Comment',
            'edit' => 'Edit Comment',
            'delete' => 'Delete Comment',
        ],
        'modal' => [
            'create' => [
                'heading' => 'Add New Comment',
                'submit' => 'Add Comment',
                'cancel' => 'Cancel',
            ],
            'edit' => [
                'heading' => 'Edit Comment',
                'submit' => 'Save Changes',
                'cancel' => 'Cancel',
            ],
            'delete' => [
                'heading' => 'Delete Comment',
                'description' => 'Are you sure you want to delete this comment? This action cannot be undone.',
                'submit' => 'Delete',
                'cancel' => 'Cancel',
            ],
        ],
    ],

    'like' => [
        'navigation' => [
            'singular' => 'Like',
            'plural' => 'Likes',
        ],
        'relations' => [
            'title' => 'Likes',
        ],
        'form' => [
            'user' => 'User',
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'user' => 'User',
                'email' => 'Email',
                'created_at' => 'Liked At',
            ],
        ],
    ],

    'country' => [
        'navigation' => [
            'singular' => 'Country',
            'plural' => 'Countries',
        ],
        'sections' => [
            'basic_info' => 'Basic Information',
            'timestamps' => 'Timestamps',
        ],
        'fields' => [
            'name' => 'Country Name',
            'name_helper' => 'Enter the full name of the country',
            'iso' => 'ISO Code',
            'iso_helper' => 'Enter the 3-letter ISO country code (e.g., USA, GBR)',
            'users_count' => 'Users Count',
        ],
        'table' => [
            'columns' => [
                'name' => 'Name',
                'iso' => 'ISO Code',
                'users_count' => 'Users',
            ],
            'filters' => [
                'has_users' => 'User Status',
                'with_users' => 'With Users',
                'without_users' => 'Without Users',
            ],
            'empty' => [
                'heading' => 'No countries found',
                'description' => 'Get started by creating your first country.',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'Countries',
            ],
            'create' => [
                'title' => 'Create Country',
            ],
            'edit' => [
                'title' => 'Edit Country',
            ],
            'view' => [
                'title' => 'View Country',
            ],
        ],
    ],

    'complaint' => [
        'navigation' => [
            'label' => 'Complaint',
            'plural_label' => 'Complaints',
            'group' => 'Customer Support',
        ],
        'status' => [
            'open' => 'Open',
            'resolved' => 'Resolved',
        ],
        'fields' => [
            'body' => 'Complaint Details',
            'body_placeholder' => 'Enter the complaint details...',
            'user' => 'Customer',
            'status' => 'Status',
            'created_at' => 'Submitted At',
            'updated_at' => 'Updated At',
        ],
        'sections' => [
            'basic_info' => 'Complaint Information',
            'customer_info' => 'Customer Information',
            'timestamps' => 'Timestamps',
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'body' => 'Complaint',
                'user' => 'Customer',
                'user_email' => 'Customer Email',
                'status' => 'Status',
                'created_at' => 'Submitted At',
                'updated_at' => 'Updated At',
            ],
            'filters' => [
                'status' => 'Status',
                'open' => 'Open',
                'resolved' => 'Resolved',
            ],
            'actions' => [
                'mark_resolved' => 'Mark as Resolved',
                'mark_open' => 'Mark as Open',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'Complaints',
            ],
            'create' => [
                'title' => 'Create Complaint',
            ],
            'edit' => [
                'title' => 'Edit Complaint',
            ],
            'view' => [
                'title' => 'View Complaint',
            ],
        ],
    ],

    'offensive_word' => [
        'navigation' => [
            'label' => 'Offensive Word',
            'plural_label' => 'Offensive Words',
            'group' => 'System',
        ],
        'severity' => [
            'high' => 'High',
            'medium' => 'Medium',
            'low' => 'Low',
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'fields' => [
            'word' => 'Word',
            'description' => 'Description',
            'severity' => 'Severity',
            'is_active' => 'Active Status',
        ],
        'sections' => [
            'basic_info' => 'Word Information',
            'settings' => 'Settings',
        ],
        'table' => [
            'columns' => [
                'id' => 'ID',
                'word' => 'Word',
                'description' => 'Description',
                'severity' => 'Severity',
                'is_active' => 'Active',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ],
            'filters' => [
                'severity' => 'Severity',
                'is_active' => 'Active Status',
            ],
        ],
        'pages' => [
            'list' => [
                'title' => 'Offensive Words',
            ],
            'create' => [
                'title' => 'Create Offensive Word',
            ],
            'edit' => [
                'title' => 'Edit Offensive Word',
            ],
            'view' => [
                'title' => 'View Offensive Word',
            ],
        ],
        'actions' => [
            'create' => 'Create Offensive Word',
            'edit' => 'Edit Offensive Word',
        ],
        'modals' => [
            'create' => [
                'description' => 'Add a new offensive word to the system.',
            ],
            'edit' => [
                'description' => 'Modify the offensive word details.',
            ],
        ],
    ],

    'navigation' => [
        'groups' => [
            'content' => 'Content',
            'customer_support' => 'Customer Support',
            'settings' => 'Settings',
        ],
    ],
];