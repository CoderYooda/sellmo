<?php

namespace Migrations;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

abstract class AddPermissions extends Migration
{
    /**
     * @return array
     */
    abstract public function getPermissionNames(): array;

    /**
     * @return string
     */
    public function getRoleName(): string
    {
        return Role::ROLE_ADMIN;
    }

    /**
     * @return string
     */
    public function getGuardName(): string
    {
        return 'web';
    }

    /**
     * @return array
     */
    public function getAdditionalRoles(): array
    {
        return [];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        foreach ($this->getPermissionNames() as $permissionName) {
            Permission::create(['guard_name' => $this->getGuardName(), 'name' => $permissionName]);
        }
        $role = Role::findByName($this->getRoleName(), $this->getGuardName());
        $role->givePermissionTo($this->getPermissionNames());

        if ($this->getAdditionalRoles()) {
            $additionalRoles = Role::where('guard_name', $this->getGuardName())
                ->whereIn('name', $this->getAdditionalRoles());

            $additionalRoles->each(function (Role $adRole) {
                $adRole->givePermissionTo($this->getPermissionNames());
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $role = Role::findByName($this->getRoleName(), $this->getGuardName());
        $role->revokePermissionTo($this->getPermissionNames());

        if ($this->getAdditionalRoles()) {
            $additionalRoles = Role::where('guard_name', $this->getGuardName())
                ->whereIn('name', $this->getAdditionalRoles());
            /** @var Role $adRole */
            foreach ($additionalRoles as $adRole) {
                $adRole->revokePermissionTo($this->getPermissionNames());
            }
        }
        foreach ($this->getPermissionNames() as $permissionName) {
            Permission::findByName($permissionName, $this->getGuardName())->delete();
        }
    }
}
