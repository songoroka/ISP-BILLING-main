<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'selcom' => [
        'base_url' => env('SELCOM_BASE_URL', 'https://api.selcom.co.tz'),
        'api_key' => env('SELCOM_API_KEY'),
        'api_secret' => env('SELCOM_API_SECRET'),
        'digest_method' => env('SELCOM_DIGEST_METHOD', 'HS256'),
        'private_key' => env('SELCOM_PRIVATE_KEY'),
        'initiate_path' => env('SELCOM_INITIATE_PATH', '/v1/checkout/initiate-pos-payment'),
        'status_path' => env('SELCOM_STATUS_PATH', '/v1/checkout/pos-payment-status'),
        'timeout' => env('SELCOM_TIMEOUT', 30),
    ],

    'azampay' => [
        'app_name' => env('AZAMPAY_APP_NAME'),
        'client_id' => env('AZAMPAY_CLIENT_ID'),
        'client_secret' => env('AZAMPAY_CLIENT_SECRET'),
        'environment' => env('AZAMPAY_ENVIRONMENT', 'sandbox'),
        'auth_base_url' => env('AZAMPAY_AUTH_BASE_URL', 'https://authenticator-sandbox.azampay.co.tz'),
        'api_base_url' => env('AZAMPAY_API_BASE_URL', 'https://sandbox.azampay.co.tz'),
        'token_path' => env('AZAMPAY_TOKEN_PATH', '/AppRegistration/GenerateToken'),
        'mno_checkout_path' => env('AZAMPAY_MNO_CHECKOUT_PATH', '/azampay/mno/checkout'),
        'transaction_status_path' => env('AZAMPAY_TRANSACTION_STATUS_PATH', '/azampay/gettransactionstatus'),
        'mno_provider' => env('AZAMPAY_MNO_PROVIDER', 'Azampesa'),
        'webhook_secret' => env('AZAMPAY_WEBHOOK_SECRET'),
        'timeout' => env('AZAMPAY_TIMEOUT', 30),
    ],

    'beem' => [
        'api_key' => env('BEEM_API_KEY'),
        'secret_key' => env('BEEM_SECRET_KEY'),
        'sms_url' => env('BEEM_SMS_URL', 'https://apisms.beem.africa/v1/send'),
        'sms_sender_id' => env('BEEM_SMS_SENDER_ID'),
        'sms_timeout' => env('BEEM_SMS_TIMEOUT', 30),
        // Beem supplies the exact BPay/Checkout and optional status URLs during merchant onboarding.
        'bpay_checkout_url' => env('BEEM_BPAY_CHECKOUT_URL'),
        'bpay_status_url' => env('BEEM_BPAY_STATUS_URL'),
        'bpay_timeout' => env('BEEM_BPAY_TIMEOUT', 30),
        'webhook_secret' => env('BEEM_WEBHOOK_SECRET'),
    ],

    'mpesa_tz' => [
        'base_url' => env('MPESA_TZ_BASE_URL', 'https://openapi.m-pesa.com'),
        'api_key' => env('MPESA_TZ_API_KEY'),
        'public_key' => env('MPESA_TZ_PUBLIC_KEY'),
        'service_provider_code' => env('MPESA_TZ_SERVICE_PROVIDER_CODE'),
        'session_path' => env('MPESA_TZ_SESSION_PATH', '/sandbox/ipg/v2/vodacom.tz/getSession/'),
        'c2b_path' => env('MPESA_TZ_C2B_PATH', '/sandbox/ipg/v2/vodacom.tz/c2bPayment/singleStage/'),
        'query_path' => env('MPESA_TZ_QUERY_PATH', '/sandbox/ipg/v2/vodacom.tz/queryTransactionStatus/'),
        'origin' => env('MPESA_TZ_ORIGIN'),
        'third_party_reference' => env('MPESA_TZ_THIRD_PARTY_REFERENCE'),
        'timeout' => env('MPESA_TZ_TIMEOUT', 30),
    ],

    'bkash' => [
        'base_url' => env('BKASH_BASE_URL'),
        'username' => env('BKASH_USERNAME'),
        'password' => env('BKASH_PASSWORD'),
        'app_key' => env('BKASH_APP_KEY'),
        'app_secret' => env('BKASH_APP_SECRET'),
    ],
];
