<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests;

use Spatie\Permission\PermissionServiceProvider;
use Tipoff\Forms\FormsServiceProvider;
use Tipoff\Authorization\AuthorizationServiceProvider;
use Tipoff\Support\SupportServiceProvider;
use Tipoff\TestSupport\BaseTestCase;

class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            SupportServiceProvider::class,
            AuthorizationServiceProvider::class,
            PermissionServiceProvider::class,
            FormsServiceProvider::class,
        ];
    }
}
