<?php

namespace App\Livewire\Sidebar;

use App\Models\Category;
use App\Models\TemplateRepository;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class SidebarTemplate extends Component
{

    public $active = true;
    public Collection $templateRepository;


    #[On('toggle-sidebar')]
    public function toogleSidebar($active)
    {
        $this->active = $active;
    }

    public function mount()
    {
        $this->templateRepository = TemplateRepository::all();
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
