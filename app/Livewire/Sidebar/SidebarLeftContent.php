<?php

namespace App\Livewire\Sidebar;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class SidebarLeftContent extends Component
{
    #[Reactive]
    public $active;

    public function mount($active)
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
        return view('livewire.sidebar.sidebar-left-content');
    }
}
