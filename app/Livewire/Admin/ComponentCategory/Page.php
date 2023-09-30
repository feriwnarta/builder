<?php

namespace App\Livewire\Admin\ComponentCategory;

use App\Models\ComponentCategory;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Page extends Component
{

    #[Rule('required|min:5')]
    public $nameCategory;

    public function saveCategory() {
        $this->validate();


        // simpan kategori
        $this->store();
    }

    private function store() {
        try {
            $resultSave = ComponentCategory::create([
                'name' => $this->nameCategory
            ]);

            if(!$resultSave) {
                Session::flash('error', 'Gagal Menyimpan Kategori');        
            }

            $this->reset();
            Session::flash('success', 'Berhasil simpan kategori');

        }catch(QueryException $e) {
            Session::flash('error', 'Gagal Menyimpan Kategori');    
        }
    }

    public function render()
    {
        return view('livewire.admin.component-category.page');
    }
}
