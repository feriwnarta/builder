<?php

namespace App\Livewire\LandingPage;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.landing-page.app')]
class LandingPage extends Component
{
    public function render()
    {
        return view('livewire.landing-page.landing-page');
    }
}
