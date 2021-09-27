<?php

namespace Jasara\LaravelAmznSPA\Tests\Unit;

use Illuminate\Http\Client\Factory;
use Illuminate\Support\Str;
use Jasara\AmznSPA\AmznSPA;
use Jasara\AmznSPA\DataTransferObjects\AuthTokensDTO;
use Jasara\AmznSPA\DataTransferObjects\GrantlessTokenDTO;
use Jasara\LaravelAmznSPA\LaravelAmznSPA;
use Jasara\LaravelAmznSPA\Tests\TestCase;

class SetupTest extends TestCase
{
    public function testInit()
    {
        config(['selling-partner-api.marketplace_id' => 'ATVPDKIKX0DER']);
        config(['selling-partner-api.application_id' => 'amzn1.sellerapps.app.appid-1234-5678-a1b2-a1b2c3d4e5f6']);

        $amzn = new LaravelAmznSPA;

        $this->assertInstanceOf(AmznSPA::class, $amzn);
    }

    public function testConfigParameters()
    {
        config(['selling-partner-api.marketplace_id' => 'ATVPDKIKX0DER']);
        config(['selling-partner-api.application_id' => 'amzn1.sellerapps.app.appid-1234-5678-a1b2-a1b2c3d4e5f6']);

        $amzn = new LaravelAmznSPA(
            new AuthTokensDTO(
                access_token: Str::random(),
            ),
            new Factory(),
            new GrantlessTokenDTO(
                access_token: Str::random(),
            ),
            marketplace_id: 'ATVPDKIKX0DER',
        );

        $this->assertInstanceOf(AmznSPA::class, $amzn);
    }
}
