<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;

class SidebarRight extends Component
{
    public $active = true;


    public function toggle($val)
    {
        $this->active = $val;
    }

    public function render()
    {
        return view('livewire.sidebar.sidebar-right');
    }
}
