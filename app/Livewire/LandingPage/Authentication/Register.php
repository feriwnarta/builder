<?php

namespace App\Livewire\LandingPage\Authentication;

use App\Models\UserRole;
use App\Services\AuthService;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.landing-page.app')]
class Register extends Component
{

    #[Rule('required|min:5')]
    public $name = '';

    #[Rule('required|email|unique:users,email')]
    public $email = '';

    #[Rule('required|min:8')]
    public $password = '';

    public function save()
    {

        // lakukan validasi terlebih dahulu
        $this->validate();

        // simpan data
        $this->store();

    }

    private function store()
    {
        $authService = app()->make(AuthService::class);

        // panggil service do register
        $authService->doRegister($this->name, $this->email, $this->password, $this);


    }

    public function render()
    {
        return view('livewire.landing-page.authentication.register');
    }
}
