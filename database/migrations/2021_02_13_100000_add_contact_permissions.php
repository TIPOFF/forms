<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\PermissionRegistrar;

class AddContactPermissions extends Migration
{
    public function up()
    {
        if (app()->has(Permission::class)) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();

            foreach ([
                         'view contacts',
                         'create contacts',
                         'update contacts'
                     ] as $name) {
                app(Permission::class)::findOrCreate($name, null);
            };
        }
    }
}