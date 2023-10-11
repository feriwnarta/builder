<?php

namespace Tests\Feature\TestAuthService;

use App\Services\AuthService;
use App\Services\Impl\AuthServiceImpl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;

class TestAuthService extends TestCase
{
    use RefreshDatabase;

    private AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = new AuthServiceImpl();
    }

    public function testAuthServiceNotNUll()
    {
        assertNotNull($this->authService);
    }


    public function testCheckUserRole()
    {
        $user = $this->authService->checkUserRole();
        self::assertEquals('User', $user->name);
    }

    public function testCreateUser()
    {
        $userRole = $this->authService->checkUserRole();
        $fullname = fake()->name();
        $email = fake()->email();
        $password = fake()->password();

        $user = $this->authService->createUser($userRole, $fullname, $email, $password);

        assertNotNull($user);
        assertEquals($fullname, $user->fullname);
        assertEquals($email, $user->email);
    }

    public function testDoRegisterSuccess()
    {

        $fullname = fake()->name();
        $email = fake()->email();
        $password = fake()->password();

        $userRegister = $this->authService->doRegister($fullname, $email, $password);
        assertNotNull($userRegister);
        assertEquals($fullname, $userRegister->fullname);
        assertEquals($email, $userRegister->email);

    }


}
