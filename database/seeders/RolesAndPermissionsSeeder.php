<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view admin']);
        Permission::create(['name' => 'edit admin']);
        Permission::create(['name' => 'delete admin']);

        Permission::create(['name' => 'view posts']);
        Permission::create(['name' => 'create posts']);
        Permission::create(['name' => 'edit posts']);
        Permission::create(['name' => 'delete posts']);

        // Create roles and assign created permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(['view admin', 'edit admin', 'delete admin', 'view posts', 'create posts', 'edit posts', 'delete posts']);

        $authorRole = Role::create(['name' => 'author']);
        $authorRole->givePermissionTo(['view posts', 'create posts', 'edit posts', 'delete posts']);

        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view posts']);
    }
}

