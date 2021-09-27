#  Laravel wrapper for Amazon's Selling Partner API SDK 

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jasara/laravel-selling-partner-api.svg?style=flat-square)](https://packagist.org/packages/jasara/laravel-selling-partner-api)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/jasara/laravel-selling-partner-api/run-tests?label=tests)](https://github.com/jasara/laravel-selling-partner-api/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code coverage](https://raw.githubusercontent.com/jasara/laravel-selling-partner-api/main/.github/coverage.svg)](https://github.com/jasara/laravel-selling-partner-api)
[![Total Downloads](https://img.shields.io/packagist/dt/jasara/laravel-selling-partner-api.svg?style=flat-square)](https://packagist.org/packages/jasara/laravel-selling-partner-api)

This package is a Laravel wrapper around [Jasara's PHP SDK for Amazon's Selling Partner API](https://github.com/jasara/php-amzn-selling-partner-api). 

## License

While this package has an [MIT license](LICENSE.md), the core PHP SDK package is not commercially licensed. If you are using this package commerically, please see the [licensing section](https://github.com/jasara/php-amzn-selling-partner-api#license) of the core PHP SDK package.

## Installation

You can install the package via composer:

```bash
composer require jasara/laravel-selling-partner-api
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Jasara\LaravelAmznSPA\LaravelAmznSPAServiceProvider" --tag="laravel-selling-partner-api-config"
```

This is the contents of the published config file:

```php
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
```

## Usage

For full usage information, see the [documentation website](https://phpspa.com/).

In this Laravel wrapper, the underlying library will be automatically configured when you set the following environment variables:

```
AMZN_SPA_MARKETPLACE_ID=ATVPDKIKX0DER
AMZN_SPA_APPLICATION_ID=amzn1.sellerapps.app.appid-1234-5678-a1b2-a1b2c3d4e5f6
AMZN_SPA_REDIRECT_URL=yourapp.com/amazon/oauth/redirect
AMZN_SPA_USE_TEST_ENDPOINTS=true
AMZN_SPA_AWS_ACCESS_KEY=AKIASECRETKEY
AMZN_SPA_AWS_SECRET_KEY=rf7x7rpjqq1tlcbbv2r9iahcmm6mluaqn8deitcl
AMZN_SPA_LWA_CLIENT_ID=17r2r9iahcmm6mlubv2r9iahcmm6mluaqnlcbbv2r9iahiahcmm6mluaqn8de
AMZN_SPA_LWA_CLIENT_SECRET=Atzr|1tlcbbv2r9iahcmm6mluaqn8d-secret
```

To call the Amazon API, first instantiate the Laravel wrapper class, passing any configuration parameters (such as client authorization tokens) into the constructor.

```php
$amzn = new \Jasara\LaravelAmznSPA\LaravelAmznSPA(
    tokens: new \Jasara\AmznSPA\DataTransferObjects\AuthTokensDTO(
        access_token: $access_token, // optional if there is a refresh token
        expires_at: $expires_at, // optional, instance of CarbonImmutable
        refresh_token: $refresh_token, // optional if there is an access token, Passing in the refresh token will automatically generate a new access token when needed
    ),
    http: $http, // instance of Illuminate\Http\Client\Factory - if you would like to stub tests, you can pass in a faked HTTP instance
    grantless_token: new \Jasara\AmznSPA\DataTransferObjects\GrantlessTokenDTO(
        access_token: $access_token, // optional, a new token will be automatically generated if not passed in
        expires_at: $expires_at, // optional, instance of CarbonImmutable
    ),
    marketplace_id: $marketplace_id, // e.g. ATVPDKIKX0DER
);
```

You can then call the underlying library resources directly, such as the [Notifications resource](https://phpspa.com/docs/resources/notifications/). The response is a data transfer object adhering to the Amazon schema.

```php
$amzn->notifications->getDestinations();
$destination_id = $response->payload[0]->destination_id;
```
