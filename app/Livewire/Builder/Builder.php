<?php

namespace App\Livewire\Builder;

use App\Models\Template;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class Builder extends Component
{
    public $builderReady = false;
    public $html = '';

    #[Url(as: 'find-template-edit')]
    public $search = '';

    public function mount()
    {
        // kirim dispatch
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
            @click="$dispatch('find-template', {id: '1'})">Klik</button>
        HTML;
    }

    /**
     * fungsi ini digunakan untuk mencari template berdasarkan id
     * fungsi in akan dijalankan saat event di trigger
     */
    #[On('find-template')]
    public function findTemplate($id)
    {
        if ($id == '') return;

        try {
            // validasi pencarian terlebih dahulu

            // lakukan pencarian data template didatabase
            $template = Template::where('template_id', $id)->firstOrFail();

            // ubah url query parameter berdasarkan id terbaru
            $this->search = $template->template_id;

            // hapus template yang tampil

            // sample
            $this->dispatch('init-builder', component_id: $this->search);
        }

        // proses data kosong / tidak ketemu
        // tampilkan pesan bahwa template tidak ada
        catch (ModelNotFoundException $e) {
        }
    }



    public function render()
    {
        return view('livewire.builder.builder');
    }
}
