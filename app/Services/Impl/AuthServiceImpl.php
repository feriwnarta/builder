<?php

namespace App\Services\Impl;

use App\Livewire\LandingPage\Authentication\Login;
use App\Livewire\LandingPage\Authentication\Register;
use App\Models\User;
use App\Models\UserRole;
use App\Services\AuthService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthServiceImpl implements AuthService
{

    public function checkUserRole(): UserRole
    {
        $user = UserRole::where('name', 'User')->first();

        if ($user != null) {
            return $user;
        }

        return UserRole::create([
            'name' => 'User'
        ]);
    }

    public function createUser(string $fullname, string $email, string $password): User
    {
        return User::create([
            'fullname' => $fullname,
            'email' => $email,
            'password' => Hash::make($password),
            'register_type' => 'email',
        ]);
    }


    public function doRegister(string $name, string $email, string $password): User
    {
        try {
            // buat user
            $user = $this->createUser($name, $email, $password);


            return $user;

        } catch (QueryException $e) {
            Session::flash('error', "ada sesuatu yang salah");
        }
    }

    public function doLogin(string $email, string $password): bool
    {
        return Auth::attempt(['email' => $email, 'password' => $password]);

    }
}
