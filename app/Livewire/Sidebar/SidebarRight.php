<?php

namespace App\Livewire\Sidebar;

use Livewire\Attributes\On;
use Livewire\Component;

class SidebarRight extends Component
{
    public $active = true;

    public function mount()
    {
        $this->dispatch('toggle-sidebar-right', active: $this->active);
    }

    public function render()
    {
        return view('livewire.sidebar.sidebar-right');
    }
}
