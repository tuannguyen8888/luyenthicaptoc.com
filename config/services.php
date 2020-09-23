<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'client_id' => '1054143066818-al5nd8e3sdpgp5g6vjco79f7o3v5c973.apps.googleusercontent.com',
        'client_secret' => '8cpO3XccSqWL0x2TYL12d9QY',
        'redirect' => 'https://luyenthicaptoc.com/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => '611709992853693',
        'client_secret' => '9c5741c7cba8588f0561a9afa96a54ce',
        'redirect' => 'https://luyenthicaptoc.com/auth/facebook/callback',
    ],
];
