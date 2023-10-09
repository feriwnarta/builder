<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function findTemplate(Templates $template)
    {
        echo $template->data;
    }

    public function saveTemplate(Request $request)
    {
        
        $data = $request->json()->all();

        if ($data !== null) {
            $id = $data['id'];
            $projectData = $data['data'];

            $result = Templates::find($id)->update(['data' => $projectData]);
        }
    }
}
