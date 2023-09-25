<?php

namespace App\Livewire\Sidebar;

use Livewire\Component;

class SidebarTemplate extends Component
{

    public $categories = [
        [
            'id' => '1',
            'title' => 'Restaurants & Cafes'
        ],
        [
            'id' => '2',
            'title' => 'Real estate'
        ],
        [
            'id' => '3',
            'title' => 'Education'
        ],
    ];

    public function mount()
    {
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
