<?php

namespace Tipoff\Forms;

use Tipoff\Forms\Models\Contact;
use Tipoff\Forms\Policies\ContactPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FormsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Contact::class => ContactPolicy::class,
            ])
            ->name('forms')
            ->hasConfigFile();
    }
}
