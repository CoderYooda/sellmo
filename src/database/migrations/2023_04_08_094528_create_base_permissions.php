<?php

use Migrations\AddPermissions;
use App\Models\Role;
use App\Models\Permission;

class CreateBasePermissions extends AddPermissions
{
    /**
     * @return array
     */
    public function getPermissionNames(): array
    {
        return Permission::DEFAULT_ADMIN_PERMISSIONS;
    }

    /**
     * @return array
     */
    public function getAdditionalRoles(): array
    {
        return [
            Role::ROLE_ADMIN,
        ];
    }
};
