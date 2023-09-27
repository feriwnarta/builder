<?php

namespace App\Livewire\Sidebar;

use Livewire\Attributes\On;
use Livewire\Component;

class Pages extends Component
{

    public $pages;

    #[On('refresh-posts')]
    public function acceptPages()
    {
        $this->pages = 'hello';
    }

    public function render()
    {
        return view('livewire.sidebar.pages');
    }
}
