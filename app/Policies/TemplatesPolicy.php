<?php

namespace App\Policies;

use App\Models\Templates;
use App\Models\User;


class TemplatesPolicy
{
    /**
     * ini akan membuat bahwa user yang membuat template yang dapat * * mengeditnya saat pembuatan template
     */
    public function viewAndEditTemplate(User $user, Templates $template): bool
    { 
        return $template->user_id == $user->id;
    }
}
