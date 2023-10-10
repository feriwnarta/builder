<?php

namespace App\Livewire\LandingPage\Authentication;

use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;


#[Layout('components.layouts.landing-page.app')]
class Login extends Component
{

    #[Rule('required|email')]
    public $email;
    #[Rule('required|min:8')]
    public $password;

    public function login()
    {
        $this->validate();


        $this->doLogin();
    }


    // proses login
    private function doLogin()
    {
        $authService = app()->make(AuthService::class);
        // panggil auth service untuk melakukan login
        $authService->doLogin($this->email, $this->password, $this);
    }

    public function render()
    {
        return view('livewire.landing-page.authentication.login');
    }
}
