<?php

namespace App\Livewire\LandingPage\Authentication;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.landing-page.app')]
class Login extends Component
{
    public function render()
    {
        return view('livewire.landing-page.authentication.login');
    }
}
