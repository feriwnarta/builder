<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use App\Models\UserTemplate;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function findTemplate(string $templateId)
    {
        $template = Templates::where('id', $templateId)->first();

        if(is_null($template)) {
           $template = UserTemplate::where('id', $templateId)->first();
        }

        echo $template->data;
    }

    public function saveTemplate(Request $request)
    {

        $data = $request->json()->all();

        if ($data !== null) {
            $id = $data['id'];
            $projectData = $data['data'];

            $result = Templates::find($id);

            if(!is_null($result)) {
                $result->update(['data' => $projectData]);
                return;
            }

            $userTemplate = UserTemplate::find($id);

            if(!is_null($userTemplate)) {
                $userTemplate->update(['data' => $projectData]);
            }
        }
    }
}
