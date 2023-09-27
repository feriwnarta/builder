<?php

namespace App\Livewire\Sidebar;

use Livewire\Attributes\On;
use Livewire\Component;

class SidebarLayer extends Component
{
    public $active = false;

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <h1>load</h1>
        </div>
        HTML;
    }


    public function render()
    {
        return view('livewire.sidebar.sidebar-layer');
    }
}
