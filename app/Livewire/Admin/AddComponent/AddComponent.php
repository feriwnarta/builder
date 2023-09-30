<?php

namespace App\Livewire\Admin\AddComponent;

use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('components.layouts.admin.app')]
class AddComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.add-component.add-component');
    }
}
