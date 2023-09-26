<?php

namespace App\Livewire\Builder;

use App\Models\Template;
use App\Models\TemplateRepository;
use App\Models\Templates;
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

        $this->getTemplate($id);
    }

    // fungsi ini digunakan untuk mendapatkan data template dari database berdasarkan kategori
    private function getTemplate(string $id)
    {
        // dapatkan data template
        $templates = TemplateRepository::first()->template()->where('categories_id', $id)->get();

        // jika template berdasarkan kategori kosong
        if ($templates->isEmpty()) {
            $this->html = '<h1>kosong</h1>';
            return;
        }

        // jika kategori ada isinya
        $format = '';
        foreach ($templates as $template) {
            $format .= "<button>{$template->title}</button>";
        }

        $this->html = $format;
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
            // $template = Templates::where('template_id', $id)->firstOrFail();

            // ubah url query parameter berdasarkan id terbaru
            $this->search = '1';

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
