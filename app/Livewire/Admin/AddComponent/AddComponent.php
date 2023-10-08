<?php

namespace App\Livewire\Admin\AddComponent;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Component as ModelsComponent;
use App\Models\ComponentCategory;
use Livewire\Attributes\Rule;

#[Layout('components.layouts.admin.app')]
class AddComponent extends Component
{

    public $categories;
    #[Rule('required')]
    public $idCategory;
    #[Rule('required')]
    public $name;
    public $media = '';
    #[Rule('required')]
    public $componentHtml;

    public function mount()
    {
        $this->categories = ComponentCategory::all();
    }

    public function saveComponent() {
        $this->validate();
        // simpan data jika berhasil
        $this->store();

        
        
    }

    private function store() {
        try {
            // simpan
            $resultSave = ModelsComponent::create([
                'component_categories_id' => $this->idCategory,
                'label' => $this->name,
                'media' => $this->media,
                'content' => $this->componentHtml,
            ]);

            // error simpan
            if(!$resultSave) {
                Session::flash('error', 'terjadi kesalahan saat menyimpan data');
            }

            // kirim pesan berhasil
            Session::flash('success', 'Data berhasil disimpan.');
        } catch(QueryException $e) {

            $errorCode = $e->errorInfo[1];

            if ($errorCode == 1062) { // Error kode 1062 adalah error "Duplicate entry" pada MySQL
                $errorMessage = 'Duplikat data ditemukan. Nama tidak boleh sama';
            } else {
                $errorMessage = 'Terjadi kesalahan saat menyimpan data.';
            }
    
            // Simpan pesan error ke dalam session flash dengan tipe error
            Session::flash('error', $errorMessage);    
        }
        
        // reset proprty
        $this->reset('idCategory', 'name', 'media', 'componentHtml');
    }
    
    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <h1>loading</h1>
        </div>
        HTML;
    }
    
    public function render()
    {
        return view('livewire.admin.add-component.add-component');
    }
}
