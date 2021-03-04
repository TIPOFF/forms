<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddContactPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
             'view contacts',
             'create contacts',
             'update contacts'
        ];

        $this->createPermissions($permissions);
    }
}
