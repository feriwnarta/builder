<?php

namespace App\Livewire\Admin\ComponentCategory;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin.app')]
class AddComponentCategory extends Component
{
    public function render()
    {
        return view('livewire.admin.component-category.add-component-category');
    }
}
