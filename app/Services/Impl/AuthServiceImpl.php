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

    public function createUser(UserRole $role, string $fullname, string $email, string $password): User
    {
        return User::create([
            'user_roles_id' => $role->id,
            'fullname' => $fullname,
            'email' => $email,
            'password' => Hash::make($password),
            'register_type' => 'email',
        ]);
    }


    public function doRegister(string $name, string $email, string $password, Register $registerComponent): void
    {
        try {
            // dapatkan role user
            $userRole = $this->checkUserRole();

            // buat user
            $user = $this->createUser($userRole, $name, $email, $password);

            if (!$user) {
                Session::flash('error', 'Gagal Membuat Akun');
                return;
            }


            if (Auth::loginUsingId($user->id)) {
                // reset field
                $registerComponent->reset();
                // redirect ke dashboard
                $registerComponent->redirect('/dashboard', navigate: true);
            }

        } catch (QueryException $e) {
            Session::flash('error', "ada sesuatu yang salah");
        }
    }

    public function doLogin(string $email, string $password, Login $loginComponent)
    {
        $isLogin = Auth::attempt(['email' => $email, 'password' => $password]);


        // check apakah user bisnis
        if ($isLogin) {

            if (auth()->user()->isAdmin()) {
                $loginComponent->redirect('admin/dashboard', navigate: true);
            } else if (auth()->user()->isUser()) {
                $loginComponent->redirect('builder', navigate: true);
            }

        }

        Session::flash('error', 'Email or password is incorrect. Please ensure your credentials are correct.');
    }
}
