<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;

class SidebarLeft extends Component
{
    public $active = true;

    public function mount() {
        $this->dispatch('toggle-sidebar', active: $this->active);
    }

    public function toggle($val)
    {
        $this->active = $val;

        $this->dispatch('toggle-sidebar', active: $this->active);
    }


    public function render()
    {
        return view('livewire.sidebar.sidebar-left');
    }
}
