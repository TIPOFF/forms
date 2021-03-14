<?php

declare(strict_types=1);

use Tipoff\Authorization\Permissions\BasePermissionsMigration;

class AddContactPermissions extends BasePermissionsMigration
{
    public function up()
    {
        $permissions = [
            'view contacts' => ['Owner', 'Executive', 'Staff'],
            'create contacts' => ['Owner', 'Executive', 'Staff'],
            'update contacts' => ['Owner', 'Executive', 'Staff'],
            'delete contacts' => ['Owner', 'Executive', 'Staff'],
        ];

        $this->createPermissions($permissions);
    }
}
