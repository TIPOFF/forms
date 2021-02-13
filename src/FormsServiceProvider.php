<?php

declare(strict_types=1);

namespace Tipoff\Forms;

use Tipoff\Support\TipoffPackage;
use Tipoff\Support\TipoffServiceProvider;

class FormsServiceProvider extends TipoffServiceProvider
{
    public function configureTipoffPackage(TipoffPackage $package): void
    {
        $package
            ->name('forms')
            ->hasConfigFile();
    }
}
