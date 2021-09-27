<?php

// config for Jasara/LaravelAmznSPA
return [
    'marketplace_id' => env('AMZN_SPA_MARKETPLACE_ID'),
    'application_id' => env('AMZN_SPA_APPLICATION_ID'),
    'redirect_url' => env('AMZN_SPA_REDIRECT_URL'),
    'use_test_endpoints' => env('AMZN_SPA_USE_TEST_ENDPOINTS'),
    'aws_access_key' => env('AMZN_SPA_AWS_ACCESS_KEY'),
    'aws_secret_key' => env('AMZN_SPA_AWS_SECRET_KEY'),
    'lwa_client_id' => env('AMZN_SPA_LWA_CLIENT_ID'),
    'lwa_client_secret' => env('AMZN_SPA_LWA_CLIENT_SECRET'),
];
