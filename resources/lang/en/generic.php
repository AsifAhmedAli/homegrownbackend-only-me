<?php

return [
    'first_name' => 'First Name',
    'last_name' => 'Last Name',
    'company' => 'Company',
    'street_address_1' => 'Street Address 1',
    'street_address_2' => 'Street Address 2',
    'change_password' => 'Change Password',
    'successfully_password_changed' => 'Password changed successfully.',
    'error' => 'Something went wrong, please try again.',
    'forgot_password' => 'Forgot Password',
    'email_verified' => 'Your email is verified.',
    'forgot_email_sent' => 'An email has been sent to you. Please check your email to reset your password.',
    'reset_password' => 'Reset Password',
    'password_confirmation' => 'Confirm Password',
    'token_expired' => 'Token is expired or invalid.',
    'password_changed' => 'Password changed successfully.',
    'protection_on_off' => 'Protection On/Off',
    'tab_password' => 'Menu Tab Password',
    'available_emails' => 'Email Template',
    'validation_errors' => 'Validation Errors',
    'already_exist' => 'Already Exist',
    'success' => 'Data saved successfully.',
    'out_of_stock' => 'Out of Stock',
    'variant_found' => 'Variant Detail',
    'no_variant_found' => 'No variant found.',
    'cart_added' => 'Cart added successfully.',
    'cart_updated' => 'Cart updated successfully.',
    'user_data' => 'User Data',
    'item_deleted' => 'Item deleted successfully',
    'quantity_exceeded' => 'Quantity exceeded.',
    'sku_exists' => 'SKU already taken.',
    'sku_saved' => 'SKU saved successfully.',
    'product_removed_from_wishlist' => 'Product removed from wishlist.',
    'product_added_to_wishlist' => 'Product added to wishlist.',
    'mywishlists' => 'My wishList data.',
    'my_orders' => 'All My Orders',
    'order_by_id' => 'Order by ID',
    'review_added' => 'Review added successfully.',
    'already_wished' => 'Already added to wishlist.',
    'stone_added' => 'Stone added successfully.',
    'stone_updated' => 'Stone updated successfully.',
    'stone_deleted' => 'Stone selected successfully.',
    'text_engraving_saved' => 'Text engraving data saved successfully.',
    'print_image_saved' => 'Print Image saved successfully.',
    'print_image_updated' => 'Print Image updated successfully.',
    'initials_saved' => 'Initials data saved successfully.',
    'address_book' => 'Address book saved successfully.',
    'address_saved' => 'Address saved successfully.',
    'address_deleted' => 'Address deleted successfully.',
    'address_updated' => 'Address updated successfully.',
    'user_profile_updated' => "User profile updated.",
    "default_address" => 'Default Address',
    "no_record" => 'No Record Found.',
    'review_submitted' => 'Your review has been submitted for approval.',
    'view_feedback' => 'View Feedback',
    'user_registered' => 'Account created successfully. A verification link has been sent to your email account.',
    // payments
    'payment' => [
        'method_saved' => 'Payment method saved successfully.',
        'method_deleted' => 'Payment method deleted successfully.',
        'error_in_delete_method' => 'Something went wrong / Payment method not found.',
        'method_marked_as_default' => 'Payment method marked as default.',
        'list_of_payment_methods' => 'Payment methods list.',
        'error_during_payment' => 'Error during payment.',
    ],

    //user

    'user' => [
        'not_logged_in' => 'User is not logged In.',
        'not_found' => 'User not found.',
        'detail' => 'User detail.',
    ],

    'mail' => [
        'gx' => [
            'from' => 'info@gx.com',
            'welcome' => [
                'subject' => 'Welcome to GX',
                'heading' => 'Dear :name,',
                'body' => 'We\'re excited to have you get started.'
            ],
            'forgot_password' => [
                'subject' => 'Reset your password',
                'body' => 'A request has been received to change the password for your account.',
            ],
            'registration' => [
                'subject' => 'Thanks for signing up!',
                'heading' => 'Welcome to :name',
                'body_description' => 'We guarantee you’ve never seen technology like this before.',
                'body_description_1' => 'From cutting edge growth tracking software, to one-on-one video calls with veteran Grow Masters, GrowX is changing the way you grow at home.',
                'body_description_2' => 'The next step is to register for your GrowX subscription and begin your journey, with us right by your side every step of the way.',
                'phrase' => 'Happy growing!',
            ],
            'growmaster_assign' => [
                'subject' => 'Grow Master assigned',
                'heading' => 'Welcome to :name',
                'body'=> 'Good news: you have been assigned a Grow Master!',
                'body2'=> 'Your Grow Master will be in touch soon, or you can log in to the GrowX app and get started immediately.'
            ],

            'subscription' => [
                'subject' => 'Successfully subscribe.',
                'heading' => 'Hello :name',
                'body' => 'Congratulations! your subscription of :kitName successfully done .',

            ],
            'subscription_to_admin' => [
                'subject' => ':userFullName successfully subscribe :subscriptionName subscription.',
                'heading' => 'Hello :name',
                'body' => 'A new subscription is done, :userFullName successfully subscribe :subscriptionName.',

            ],
            'thankyou' => [
                'subject' => 'Thanks for your message!',
                'body' => 'Thank you for taking the time to contact us. <br> We will get in touch with you shortly.'
            ],
            'admin_contact' => [
                'subject' => 'Customer Query Notification',
                'body' => 'A customer inquiry has been received.'
            ],
            'verify_account' => [
                'subject'   => 'Please verify your account'
            ],
            'WEB_URL' => env('WEB_URL_GX', 'https://gx.dotlogicstest.com'),

        ],
        'hgp' => [
            'from' => 'info@hgp.com',
            'welcome' => [
                'subject' => 'Welcome to HGP',
                'heading' => 'Welcome!',
                'body' => 'We\'re excited to have you get started.'
            ],
            'forgot_password' => [
                'subject' => 'Reset your password',
                'body' => 'A request has been received to change the password for your account.'
            ],
            'registration' => [
                'subject' => 'Thanks for signing up!',
                'heading' => 'Welcome to :name',
                'body_description' => 'Welcome to the <strong>:name</strong>',
                'body_description_1' => 'You are now registered with Homegrown Pros, which means that the world’s most respected brand of hydroponic farming equipment is just a click away.',
                'body_description_2' => 'Take advantage of the incredible products available on our website and get started with your next grow today.',
                'company_name' => 'Homegrown Revolution.',
                'phrase' => 'Homegrown Pros',
            ],
            'thankyou' => [
                'subject' => 'Thanks for your message!',
                'body' => 'Thank you for taking the time to contact us. <br> We will get in touch with you shortly.'
            ],
            'admin_contact' => [
                'subject' => 'Customer Query Notification',
                'body' => 'A customer inquiry has been received.'
            ],
            'verify_account' => [
                'subject'   => 'Please verify your account',
                'body'      => 'You have successfully registered account, click on the button below to verify it'
            ],
            'WEB_URL' => env('WEB_URL', 'https://hgp.dotlogicstest.com'),
            'user_kit_status' => [
                'subject' => 'Kit Tracking number'
            ]
        ],
//        'invoice_subject' => 'Invoice for Order #:id',
        'invoice_subject' => 'Order confirmation for :name from :company',
        'new_order_text' => 'A new order has been placed. The order id is #:order_id',
        'order_details' => 'Order Detail',
        'view_order' => 'View Order',
        'payment_method' => 'Payment Method',
        'if_you\’re_having_trouble' => 'If you’re having trouble clicking the "View Order" button, copy and paste the URL below into your web browser:'
    ],
    'data' => 'Data',
    'subscribed_successfully' => 'Subscribed successfully',
    'already_subscribed' => 'You have already subscribed.',
    'no_subscription_found' => 'No subscription found.',
    'invalid_transaction_id' => 'Transaction id is invalid',
    'kit' => [
        'all' => 'All Kit Data',
        'detail' => 'Kit Detail',
        'not_exist' => 'No kit found, please purchase any kit for further processing',
        'not_found' => 'No kit found, please try another one!',
    ],
    'grow_log_detail' => [
        'add' => 'Grow Log detail created successfully.',
        'update' => 'Grow Log detail updated successfully.',
        'not_update' => 'Record not updated successfully.',
    ],
    'account_not_verified' => 'Account verification failed.',
    'account_verified' => 'Account Verified.',
    'status_changed'    => 'Status changes successfully.',
    'status_unchanged'    => 'Status already changed.',
    'tracking_number_changed' => 'Tracking Number changed.'
];
