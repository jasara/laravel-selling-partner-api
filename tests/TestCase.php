<?php

namespace Jasara\LaravelAmznSPA\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Jasara\LaravelAmznSPA\LaravelAmznSPAServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Jasara\\LaravelAmznSPA\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelAmznSPAServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        //
    }
}
