<?php

declare(strict_types=1);

namespace Tipoff\Forms\Tests\Support\Providers;

use Tipoff\Forms\Nova\Contact;
use Tipoff\TestSupport\Providers\BaseNovaPackageServiceProvider;

class NovaPackageServiceProvider extends BaseNovaPackageServiceProvider
{
    public static array $packageResources = [
        Contact::class,
    ];
}