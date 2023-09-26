<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function findTemplate(Templates $template) {


        echo $template->data;

    }
}
