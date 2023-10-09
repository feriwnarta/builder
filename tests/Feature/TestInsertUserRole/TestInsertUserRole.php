<?php

namespace Tests\Feature\TestInsertUserRole;

use App\Models\Permission;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

class TestInsertUserRole extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testInsertUserRoleAdmin(): void
    {

        $role = new UserRole(['name' => 'Admin']);
        $role->save();

        $user = User::create([
            'fullname' => 'admin',
            'email' => 'admin26@gmail.com',
            'phone_number' => '085714342529',
            'register_type' => 'email',
            'password' => 'testtest',
            'user_roles_id' => $role->id,
        ]);

        

        $permission = new Permission(['users_id' => $user->id, 'name' => 'admin_all',]);
        $permission->save();

        assertTrue($permission);

    }


    // public function testInsertUserRole(): void {
    //     $role = new UserRole(['name' => 'User']);
    //     $role->save();

    //     $user = User::create([
    //         'fullname' => 'user',
    //         'email' => 'user@gmail.com',
    //         'phone_number' => '085714342529',
    //         'register_type' => 'email',
    //         'password' => 'testtest',
    //         'user_roles_id' => $role->id,
    //     ]);

        

    //     $permission = new Permission(['users_id' => $user->id, 'name' => 'user_all',]);
    //     $permission->save();

    //     assertTrue($permission);
    // }
}
