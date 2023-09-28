<?php

namespace App\Livewire\Sidebar;

use App\Models\Component as ModelsComponent;
use Livewire\Component;

class SidebarComponent extends Component
{


    public function mount() {
        // dapatkan category component
        $components = ModelsComponent::get();

        $componentJson = $components->map(function($component) {
            return [
                'id' => $component->id,
                'category' => $component->category->name,
                'label' => $component->label,
                'media' => $component->media,
                'content' => $component->content,
            ];
        })->toJson();


        // jika user adalah kreator
        $this->dispatch('init-builder', component_id: '9a39d9ee-1f67-4cb7-8819-540989c01105', block: $componentJson);
    }

    public function render()
    {
        return view('livewire.sidebar.sidebar-component');
    }


}
