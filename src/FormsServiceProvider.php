<?php

declare(strict_types=1);

namespace Tipoff\Forms;

use Tipoff\Forms\Models\Forms;
use Tipoff\Forms\Policies\FormsPolicy;
use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FormsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->hasPolicies([
                Forms::class => FormsPolicy::class,
            ])
            ->name('forms')
            ->hasConfigFile();
    }
}
