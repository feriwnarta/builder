<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    public function findTemplate(Templates $template)
    {
        echo $template->data;
    }

    public function saveTemplate(Request $request)
    {
        Log::info('test');
        $data = $request->json()->all();

        if ($data !== null) {
            $id = $data['id'];
            $projectData = $data['data'];

            $result = Templates::find($id)->update(['data' => $projectData]);
        }
    }
}
