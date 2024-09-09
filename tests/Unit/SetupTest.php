<?php

namespace Jasara\LaravelAmznSPA\Tests\Unit;

use Carbon\CarbonImmutable;
use Illuminate\Http\Client\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Jasara\AmznSPA\AmznSPA;
use Jasara\AmznSPA\Data\AuthTokens;
use Jasara\AmznSPA\Data\GrantlessToken;
use Jasara\AmznSPA\Data\Responses\Notifications\GetSubscriptionResponse;
use Jasara\AmznSPA\Exceptions\AuthenticationException;
use Jasara\LaravelAmznSPA\LaravelAmznSPA;
use Jasara\LaravelAmznSPA\Tests\TestCase;

class SetupTest extends TestCase
{
    public function testInit()
    {
        $this->setupConfigKeys();

        $amzn = new LaravelAmznSPA;

        $this->assertInstanceOf(AmznSPA::class, $amzn);
    }

    public function testConfigParameters()
    {
        $this->setupConfigKeys();

        $amzn = new LaravelAmznSPA(
            new AuthTokens(
                access_token: Str::random(),
                refresh_token: null,
                expires_at: null,
            ),
            new Factory(),
            new GrantlessToken(
                access_token: Str::random(),
                expires_at: null,
            ),
            marketplace_id: 'ATVPDKIKX0DER',
        );

        $this->assertInstanceOf(AmznSPA::class, $amzn);
    }

    public function testFakeHttpCall()
    {
        $this->setupConfigKeys();

        Http::fake([
            '*' => Http::response([
                'payload' => [
                    'subscriptionId' => '7fcacc7e-727b-11e9-8848-1681be663d3e',
                    'payloadVersion' => '1.0',
                    'destinationId' => '3acafc7e-121b-1329-8ae8-1571be663aa2',
                ],
            ], 200),
        ]);

        $amzn = new LaravelAmznSPA(
            new AuthTokens(
                access_token: Str::random(),
                refresh_token: Str::random(),
                expires_at: CarbonImmutable::now()->addHour(),
            ),
        );
        $response = $amzn->notifications->getSubscription('ANY_OFFER_CHANGED');

        $this->assertInstanceOf(GetSubscriptionResponse::class, $response);
        $this->assertEquals('7fcacc7e-727b-11e9-8848-1681be663d3e', $response->payload->subscription_id);
    }

    public function testHandle401()
    {
        $this->setupConfigKeys();

        $this->expectException(AuthenticationException::class);

        $state = Str::random();

        Http::fake([
            '*' => Http::response([
                'error_description' => 'Client authentication failed',
                'error' => 'invalid_client',
            ], 401, ['x-amzn-RequestId' => 'test']),
        ]);

        $amzn = new LaravelAmznSPA(
            new AuthTokens(
                access_token: Str::random(),
                refresh_token: Str::random(),
                expires_at: CarbonImmutable::now(),
            ),
        );

        $amzn->lwa->getTokensFromRedirect($state, [
            'state' => $state,
            'spapi_oauth_code' => Str::random(),
        ]);
    }

    public function setupConfigKeys()
    {
        config(['selling-partner-api.marketplace_id' => 'ATVPDKIKX0DER']);
        config(['selling-partner-api.application_id' => 'amzn1.sellerapps.app.appid-1234-5678-a1b2-a1b2c3d4e5f6']);
        config(['selling-partner-api.lwa_client_id' => Str::random()]);
        config(['selling-partner-api.lwa_client_secret' => Str::random()]);
        config(['selling-partner-api.aws_access_key' => Str::random()]);
        config(['selling-partner-api.aws_secret_key' => Str::random()]);
        config(['selling-partner-api.redirect_url' => Str::random()]);
    }
}
