<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests;

use Laravel\Nova\NovaCoreServiceProvider;
use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Addresses\AddressesServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Forms\FormsServiceProvider;
use Tipoff\Forms\Tests\Support\Providers\NovaPackageServiceProvider;
use Tipoff\Locations\LocationsServiceProvider;
use Tipoff\Statuses\StatusesServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AddressesServiceProvider::class,
            StatusesServiceProvider::class,
            AuthorizationServiceProvider::class,
            PermissionServiceProvider::class,
            LocationsServiceProvider::class,
            FormsServiceProvider::class,
            NovaCoreServiceProvider::class,
            NovaPackageServiceProvider::class,
        ];
    }
}
