<?php

namespace App\Livewire\Builder;

use App\Models\Template;
use App\Models\TemplateRepository;
use App\Models\Templates;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use SebastianBergmann\Template\Template as TemplateTemplate;

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

            $format .= <<<HTML
                <button class="btn btn-menu-item" @click="\$dispatch('find-template', {id: '$template->id'})">{$template->title}</button>
            HTML;
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


        // lakukan pengecekan terlebih dahulu untuk user yang login dan memilih template
        // apakah template yang dipilih sudah ditambahkan ke table template
        // jika belum maka tambahkan dulu jika sudah maka lanjutkan menggunakan id yang sebelumnya sudah ditambahkan 
        // ditemplate
        $dummyUserLog = '9a395c55-373a-45e0-b22f-f5e630d3be59';
        $resultCheck = $this->checkAddedTemplate($id, $dummyUserLog);


        // check terlebih dahulu apakah tempalate sudah pernah dipakai dan diedit
        // jika sudah ditambahkan maka cukup update id nya
        if ($resultCheck != null) {
            return;
        }


        // langkah ini jika user belum menambahkan template


        // insert template baru
        // param 1 => template id
        // param 2 => user id 
        // param 3 => type (edit, create)
        $result = $this->addedNewTemplate($id, $dummyUserLog, 'EDIT');


        if ($result == 'error' || $result == null) {
            $this->html = 'error saat buat user';
            return;
        }

        $templateId = $result->id;

        // ambil data dari template id
        $resultData = $this->getData($templateId);

        if ($resultData == 'error' || $resultData == null) {
            $this->html = 'error saat ambil data';
            return;
        }


        try {
            // validasi pencarian terlebih dahulu

            // ubah url query parameter berdasarkan id terbaru
            $this->search = $resultData->id;

            // hapus template yang tampil

            // sample
            $this->dispatch('init-builder', component_id: $this->search);
        }

        // proses data kosong / tidak ketemu
        // tampilkan pesan bahwa template tidak ada
        catch (ModelNotFoundException $e) {
        }
    }

    private function getData($id)
    {
        try {
            $user = Templates::findOrFail($id);


            return $user;
        } catch (ModelNotFoundException $e) {
            return 'error';
        }
    }

    private function addedNewTemplate($id, $userId, $type)
    {
        try {
            // cari data template 
            $template = Templates::where('id', $id)->first();

            if (empty($template)) {
                return 'error';
            }

            $user = Templates::create([
                'user_id' => $userId,
                'template_id' => $id,
                'data' => $template->data,
                'type' => $type
            ]);

            return $user;
        } catch (QueryException $e) {
            return 'error';
        }


        return $user;
    }

    private function checkAddedTemplate($idTemplate, $userId): ?Templates
    {
        $template = Templates::where('id', $idTemplate)
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->first();

        return $template;
    }


    public function render()
    {
        return view('livewire.builder.builder');
    }
}
