<?php

declare(strict_types=1);

namespace Tipoff\Forms;

use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Models\ContactResponse;
use Tipoff\Forms\Policies\ContactPolicy;
use Tipoff\Forms\Policies\ContactResponsePolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FormsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Contact::class => ContactPolicy::class,
                ContactResponse::class => ContactResponsePolicy::class,
            ])
            ->hasNovaResources([
                \Tipoff\Forms\Nova\Contact::class,
                \Tipoff\Forms\Nova\ContactResponse::class,
            ])
            ->name('forms')
            ->hasConfigFile();
    }
}
