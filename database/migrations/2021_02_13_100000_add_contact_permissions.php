<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddContactPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view contacts' => ['Owner', 'Staff']
        ];

        $this->createPermissions($permissions);
    }
}
