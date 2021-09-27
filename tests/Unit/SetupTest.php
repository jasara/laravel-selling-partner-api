<?php

namespace Jasara\LaravelAmznSPA\Tests\Unit;

use Jasara\AmznSPA\AmznSPA;
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
}
