<?php

namespace App\Livewire\LandingPage\Authentication;

use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $isLogin = $authService->doLogin($this->email, $this->password);

        // check apakah user bisnis
        if ($isLogin) {

            $user = \auth()->user();


            if ($user->hasRole('admin') || $user->hasRole('Super-Admin')) {
                Log::info("{$user->id}, login");
                $this->redirect('admin/dashboard', navigate: true);

                return;
            }
            $this->redirect('builder', navigate: true);
            return;

        }

        Session::flash('error', 'Email or password is incorrect. Please ensure your credentials are correct.');
    }

    public function render()
    {
        return view('livewire.landing-page.authentication.login');
    }
}
