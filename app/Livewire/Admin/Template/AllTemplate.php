<?php

namespace App\Livewire\Admin\Template;

use App\Models\Templates;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.admin.app')]
class AllTemplate extends Component
{
    public function createTemplate() {
        $user = auth()->user();

        $this->storeTemplate($user->id);
    }

    private function storeTemplate($id) {
        $template = Templates::create([
            'data' => '',
            'title' => 'new site',
            'user_id' => $id,
            'type' => 'create',
        ]);

        if(!$template) {
            // balikan gagal simpan template
        }

        $urlNavigation = "/builder/?mode/edit/component={$template->id}";

        $this->redirect($urlNavigation, navigate:false);

    }

    public function render()
    {
        return view('livewire.admin.template.all-template');
    }
}
