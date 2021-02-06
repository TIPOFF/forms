<?php

namespace Tipoff\Forms;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tipoff\Forms\Commands\FormsCommand;

class FormsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('forms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_forms_table')
            ->hasCommand(FormsCommand::class);
    }
}
