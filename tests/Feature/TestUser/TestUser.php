<?php

namespace Tests\Feature\TestUser;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TestUser extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        DB::delete('delete from users');
    }


    /**
     * A basic feature test example.
     */
    public function testInsertUser(): void
    {
        $user = User::create([
            'name' => 'feri',
            'username' => 'feriwnarta',
            'email' => 'feriwnarta26@gmail.com',
            'phone_number' => '085714342528',
            'password' => 'testtest'
        ]);

        self::assertTrue($user);
    }
}
