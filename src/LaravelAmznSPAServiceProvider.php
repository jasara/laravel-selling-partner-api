<?php

namespace Jasara\LaravelAmznSPA;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelAmznSPAServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-selling-partner-api')
            ->hasConfigFile();
    }
}
