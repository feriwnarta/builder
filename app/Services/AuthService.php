<?php

namespace App\Services;

use App\Livewire\LandingPage\Authentication\Login;
use App\Livewire\LandingPage\Authentication\Register;
use App\Models\User;
use App\Models\UserRole;

interface AuthService
{
    public function checkUserRole(): UserRole;

    public function createUser(string $fullname, string $email, string $password): User;

    public function doRegister(string $name, string $email, string $password): User;

    public function doLogin(string $email, string $password): bool;
}
