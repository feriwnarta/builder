<?php

namespace App\Livewire\Navbar;

use Livewire\Attributes\Js;
use Livewire\Component;

class NavbarBuilder extends Component
{

    public function dashboard() {
        $this->redirect("/user");
    }
    public function render()
    {
        return view('livewire.navbar.navbar-builder');
    }
}
