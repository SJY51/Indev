<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserAndRoleSeeder extends Seeder
{


    public function run()
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);

        $admin = User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
                'phone' => '+1111111'
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'phone' => '+1111111',
                'password' => bcrypt('TestPassw0rD'),
            ]
        );

        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        $createUsersPermission = Permission::firstOrCreate(['name' => 'create users', 'guard_name' => 'api']);

        if (!$adminRole->hasPermissionTo('create users')) {
            $adminRole->givePermissionTo($createUsersPermission);
        }
    }


}
