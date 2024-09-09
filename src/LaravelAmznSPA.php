<?php

namespace Jasara\LaravelAmznSPA;

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Jasara\AmznSPA\AmznSPA;
use Jasara\AmznSPA\AmznSPAConfig;
use Jasara\AmznSPA\Data\AuthTokens;
use Jasara\AmznSPA\Data\GrantlessToken;

class LaravelAmznSPA extends AmznSPA
{
    public function __construct(
        ?AuthTokens $tokens = null,
        ?Factory $http = null,
        ?GrantlessToken $grantless_token = null,
        ?string $marketplace_id = null,
    ) {
        $marketplace_id = $marketplace_id ?: config('selling-partner-api.marketplace_id');
        $config = $this->configFromEnv($marketplace_id);

        if ($tokens) {
            $config->setTokens($tokens);
        }
        if ($http) {
            $config->setHttp($http);
        } else {
            $http = Http::getFacadeRoot();

            $config->setHttp($http);
        }
        if ($grantless_token) {
            $config->setGrantlessToken($grantless_token);
        }

        parent::__construct($config);
    }

    public function configFromEnv(string $marketplace_id): AmznSPAConfig
    {
        return new AmznSPAConfig(
            marketplace_id: $marketplace_id,
            application_id: config('selling-partner-api.application_id'),
            redirect_url: config('selling-partner-api.redirect_url'),
            use_test_endpoints: config('selling-partner-api.use_test_endpoints') ?: false,
            aws_access_key: config('selling-partner-api.aws_access_key'),
            aws_secret_key: config('selling-partner-api.aws_secret_key'),
            lwa_client_id: config('selling-partner-api.lwa_client_id'),
            lwa_client_secret: config('selling-partner-api.lwa_client_secret'),
        );
    }
}
