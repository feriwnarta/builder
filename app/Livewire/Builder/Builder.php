<?php

namespace App\Livewire\Builder;

use App\Models\Template;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Renderless;
use Livewire\Attributes\Url;
use Livewire\Component;

class Builder extends Component
{
    public $builderReady = false;
    public $html = '';

    #[Url(as: 'cmpnt')]
    public $search = '';

    public function mount()
    {
        $this->dispatch('find-template', id: $this->search);
    }


    #[On('load-template')]
    public function loadTemplates($id)
    {

        $this->html .= <<<'HTML'
            <div id="loadTemplate" style="width: 100%; height: 100%; background-color: #F5F6F8; z-index: 1;" class="position-relative">
                <div class="position-absolute top-50 start-50 translate-middle">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div> 
        HTML;

        $this->getTemplate();
    }

    private function getTemplate()
    {

        $this->html = <<<'HTML'
            <button class="btn btn-menu-item"
            @click="$dispatch('find-template', {id: 'test'})">Klik</button>
        HTML;
    }


    #[On('find-template')]
    public function findTemplate($id)
    {
        $this->search = $id;

        // sample
        $this->dispatch('init-builder', component_id: $this->search);
    }



    public function render()
    {
        return view('livewire.builder.builder');
    }
}
