<?php

namespace App\Livewire\Builder;

use App\Models\TemplateRepository;
use App\Models\Templates;
use App\Models\UserTemplate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use League\Uri\UriTemplate\Template;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use App\Models\Component as ModelsComponent;
use Livewire\WithFileUploads;


class Builder extends Component
{

    use WithFileUploads;

    public $builderReady = false;
    public $html = '';
    public $modeBuilder = 'edit';


    #[Url(as: 'file/q')]
    public $search = '';
    #[Validate('image|max:1024')] // 1MB Max
    public $thumbnail;

    public function mount()
    {
        $url = $this->destructUrl($this->search);


        // jika url kosong maka proses init builder
        if ($url == null) {

            // cek url
            if(!empty($this->search)) {
                $this->initBuilderByTemplate($this->search);
                return;
            }

            // nanti pasang authorisasi
            $this->dispatch('find-template', id: $this->search); // jika user sebagai pebisnis

            return;
        }

        $id = $url['id'];
        $mode = $url['mode'];



        if ($mode == 'create') {
            // arahkan ke builder sebagai template baru
            $this->newTemplate($id);

            $this->modeBuilder = 'create';
        }
    }

    /**
     * @param $templateId
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * fungsi ini digunakan untuk membuat template baru
     * hanya bisa diakses admin / creator
     */
    private function newTemplate($templateId)
    {
        $template = $this->getTemplateEdit($templateId);

        // authorisasi kepemilikan template terlebih dahulu
        $this->authorize('viewAndEditTemplate', $template);

        if ($template == null) {
            // balikan pesan error
            return;
        }

        $id = $template->id;

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

    // fungsi ini digunakan untuk mendapatkan data template berdasarkan id
    private function getTemplateEdit($id)
    {
        $templates = Templates::find($id);
        return $templates;
    }

    /**
     * fungsi ini digunakan untuk memecah url parameter yang digunakan untuk
     * mendapatkan keperluan inisialisasi builder
     * terdapat 3 node url (id template / mode / type)
     * (4asdkhj12/mode/edit atau create)
     */
    private function destructUrl(string $url)
    {
        if (!isset($url)) {
            return null;
        }

        $urlSplit = explode('/', $url);

        // jika panjang url diabwah 3
        if (sizeof($urlSplit) < 3) {
            return null;
        }

        $templateId = $urlSplit[0];

        $mode = $urlSplit[2];

        return array(
            'id' => $templateId,
            'mode' => $mode
        );
    }


    // fungsi ini digunakna untuk menampilkan
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
//        $templates = \App\Models\Templates::join('template_repositories', 'templates.id', '=', 'template_repositories.template_id')
//            ->where('templates.categories_id', $id)
//            ->select('templates.id', 'templates.title') // Gantilah '*' dengan nama kolom yang Anda butuhkan
//            ->get();
        $template = TemplateRepository::find($id)->template;


        // jika template berdasarkan kategori kosong
        if (is_null($template)) {
            $this->html = '<h1>kosong</h1>';
            return;
        }

        $this->dispatch('find-template', ['id' => $template->id]);

//        // jika kategori ada isinya
//        $format = '';
//        foreach ($templates as $template) {
//            $this->js("console.log('$template->id')");
//
//            $format = <<<HTML
//            <button class="btn btn-menu-item" @click="\$dispatch('find-template', {id: '$template->id'})">{$template->title}</button>
//            HTML;
//        }
//
//
//        $this->html = $format;
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
        // result check akan berisi id template yang baru dibuat / sudah ada
        $userId = auth()->user()->id;
        // $resultCheck = $this->checkAddedTemplate($id, $userId);


        // check terlebih dahulu apakah tempalate sudah pernah dipakai dan diedit
        // jika sudah ditambahkan maka cukup update id nya
//        if ($resultCheck != null) {
//
//            // dapatkan id template
//            $id = $resultCheck->id;
//
//            // inisialisasi grapes js
//            $this->initBuilderByTemplate($id);
//
//            return;
//        }



        // check kepemilikan template ini berdasarkan id
//        $result = $this->checkTemplateOwner($id, $userId);

        // error ini disebabkan jika ada kegagalan query pencarian template
//        if ($result == 'check error') {
//            $this->html = 'error check template';
//            return;
//        }
//
//        // error ini disebabkan jika id template yang digunakan berasal dari id lain
//        if ($result == 'not authorize') {
//            $this->html = 'reject template';
//            return;
//        }
//
//        // ubah id dengan id yang baru diganti
//        if ($result !== 'make new') {
//            $id = $result;
//        }

        // langkah ini jika user belum menambahkan template
        // insert template baru
        // param 1 => template id
        // param 2 => user id
        // param 3 => type (edit, create)
        $result = $this->addedNewTemplate($id, $userId);


        if ($result == 'error' || $result == null) {
            $this->html = '';
            return;
        }

        $templateId = $result->id;

        // ambil data dari template id
        $resultData = $this->getData($templateId);

        if ($resultData == 'error' || $resultData == null) {
            $this->html = 'error saat ambil data';
            return;
        }


        // init builder
        $this->initBuilderByTemplate($resultData->id);

    }

    /**
     * @param $templateId
     * @param $userId
     * @return string
     * fungsi ini digunakan untuk melakukan pengecekan kepemilikan template
     * saat user memilih template pertama kali fungsi ini digunakan untuk mengambil id pemilik template
     */
    private function checkTemplateOwner($templateId, $userId)
    {

        try {
            $template = Templates::where('id', $templateId)->where('user_id', $userId)->first();

            // check exisiting template
            if ($template == null) {
                $existingTemplate = Templates::where('template_id', $templateId)->where('user_id', $userId)->first();


                if ($existingTemplate != null) {
                    // ubah url menjadi id template yang sudah ada
                    $this->search = $existingTemplate->id;
                    return $existingTemplate->id;
                }

                return 'make new';
            }


            if ($template == null) {
                return 'not authorize';
            }

            return 'authorize';
        } catch (QueryException $e) {
            return 'check error';
        }
    }

    private function initBuilderByTemplate($idTemplate)
    {
        try {
            // validasi pencarian terlebih dahulu

            // ubah url query parameter berdasarkan id terbaru
            $this->search = $idTemplate;


            // kirim event ke init js untuk segera melakukan editing
            $this->dispatch('init-builder', component_id: $this->search, block: null);

        }

            // proses data kosong / tidak ketemu
            // tampilkan pesan bahwa template tidak ada
        catch (ModelNotFoundException $e) {

            $this->html = 'error model not found';
        }
    }

    private function getData($id)
    {
        try {
            $user = UserTemplate::findOrFail($id);

            return $user;
        } catch (ModelNotFoundException $e) {
            return 'error';
        }
    }

    private function addedNewTemplate($id, $userId)
    {
        try {
            // cari data template
            $template = Templates::where('id', $id)->first();

            if (is_null($template)) {
                return 'error';
            }

            return UserTemplate::create([
                'user_id' => $userId,
                'data' => $template->data,
                'template_id' => $template->id,
            ]);

//            $user = Templates::create([
//                'user_id' => $userId,
//                'template_id' => $id,
//                'data' => $template->data,
//                'type' => $type
//            ]);

        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return 'error';
        }


        return $user;
    }

    /**
     * @param $idTemplate
     * @param $userId
     * @return Templates|null
     * fungsi ini digunakan untuk memerikan apakah user sebelumnya sudah memiliki template
     */
    private function checkAddedTemplate($idTemplate, $userId): ?Templates
    {
        // saat pertama kali di init
        $template = Templates::where('id', $idTemplate)
            ->whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })
            ->first();

        // saat kedua kali template diklik
        if ($template == null) {

            $exisitingTemplate = Templates::where('template_id', $idTemplate)->where('user_id', $userId)->first();

            if ($exisitingTemplate !== null) {
                $this->search = $exisitingTemplate->id;
                return $exisitingTemplate;
            }

            return null;
        }

        return $template;
    }


    public function render()
    {
        return view('livewire.builder.builder');
    }
}
