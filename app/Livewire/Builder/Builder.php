<?php

namespace App\Livewire\Builder;

use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Attributes\Renderless;
use Livewire\Component;

class Builder extends Component
{
    public $builderReady = false;
    public $html = '';


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
            @click="$dispatch('init-builder')">Klik</button>

        HTML;
    }



    public function render()
    {
        return view('livewire.builder.builder');
    }
}
