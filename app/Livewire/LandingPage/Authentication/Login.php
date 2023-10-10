<?php

namespace App\Livewire\LandingPage\Authentication;

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

    private function doLogin()
    {


        $isLogin = Auth::attempt(['email' => $this->email, 'password' => $this->password]);


        // check apakah user bisnis
        if ($isLogin) {

            if (auth()->user()->isAdmin()) {
                $this->redirect('admin/dashboard', navigate: true);
            } else if (auth()->user()->isUser()) {
                $this->redirect('builder', navigate: true);
            }

        }

        Session::flash('error', 'Email or password is incorrect. Please ensure your credentials are correct.');
    }

    public function render()
    {
        return view('livewire.landing-page.authentication.login');
    }
}
