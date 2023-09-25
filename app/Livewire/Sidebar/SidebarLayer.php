<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;

class SidebarLayer extends Component
{
    public function mount()
    {
        sleep(2);
    }

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
