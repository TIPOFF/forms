<?php

declare(strict_types=1);

namespace Tipoff\Forms;

use Tipoff\Forms\Policies\FormPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FormsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Form::class => FormPolicy::class,
            ])
            ->name('forms')
            ->hasConfigFile();
    }
}
