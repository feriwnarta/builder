<?php

namespace App\Livewire\Sidebar;

use App\Models\Category;
use Livewire\Component;

class SidebarTemplate extends Component
{

    public $categories;
    

    public function mount()
    {
        $this->categories = Category::all();

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
