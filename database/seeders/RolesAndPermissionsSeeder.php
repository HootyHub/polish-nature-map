<?php

namespace Database\Seeders;

use App\Enums\Permissions as PermissionsEnum;
use App\Roles\AdminRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // https://spatie.be/docs/laravel-permission/v6/advanced-usage/seeding#content-flush-cache-beforeafter-seeding
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $arrayOfPermissionNames = PermissionsEnum::getAllValues();

        $permissions = collect($arrayOfPermissionNames)->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        $permissionsInDatabase = Permission::all();
        foreach ($permissionsInDatabase as $permission) {
            if (! in_array($permission->name, $arrayOfPermissionNames)) {
                $permission->delete();
            }
        }

        $permissions->each(function ($permission) {
            Permission::firstOrCreate($permission);
        });

        $roles = [
            new AdminRole(),
        ];

        $rolesInDatabase = Role::all();
        foreach ($rolesInDatabase as $role) {
            if (! in_array($role->name, array_map(function ($role) {
                return $role->getName();
            }, $roles))) {
                $role->delete();
            }
        }

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role->getName()])
                ->syncPermissions($role->getPermissions());
        }
    }
}
