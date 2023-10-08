<?php

namespace App\Livewire\Sidebar;

use App\Models\Component as ModelsComponent;
use App\Models\Templates;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\Js;
use Livewire\Attributes\Url;
use Livewire\Component;

class SidebarComponent extends Component
{
    #[Url(as: 'mode/edit/component', history: true)]
    public $urlTemplate = '';

    public function mount()
    {
        
        // dapatkan id template edit dari url 
        $template = $this->getTemplateEdit($this->urlTemplate);

        $this->js("console.log('{$this->urlTemplate}')");

        // harus melakukan authorisasi kepemilikan template

        if ($template == null) {
            // tampilkan pesan error
            return;
        }

        $id = $template->id;

        // dapatkan category component
        $components = ModelsComponent::get();

        $componentJson = $components->map(function ($component) {
            return [
                'id' => $component->id,
                'category' => $component->category->name,
                'label' => $component->label,
                'media' => $component->media,
                'content' => $component->content,
            ];
        })->toJson();

        // jika user adalah kreator / admin
        $this->dispatch('init-builder', component_id: $id, block: $componentJson);

    }

    

    private function getTemplateEdit($id)
    {

        $templates = Templates::find($id);
        return $templates;
    }

    public function render()
    {
        return view('livewire.sidebar.sidebar-component');
    }
}
