<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = Permission::create(['name' => 'make-template']);
        $role = Role::create(['name' => 'Super-Admin']);
        $role->givePermissionTo($permission);
        $user = User::create([
            'fullname' => 'admin',
            'email' => 'feriwnarta26@gmail.com',
            'phone_number' => '085714342528',
            'password' => Hash::make('adminlogin'),
            'register_type' => 'email',
        ]);

        $user->assignRole($role);

    }
}
