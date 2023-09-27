<?php

namespace App\Livewire\Sidebar;

use App\Models\Category;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class SidebarTemplate extends Component
{

    public $active = true;
    public $categories;


    #[On('toggle-sidebar')]
    public function toogleSidebar($active)
    {
        $this->active = $active;
    }

    public function mount()
    {
        $this->categories = Category::orderBy('name', 'ASC')->get();
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
        return view('livewire.sidebar.sidebar-template');
    }
}
