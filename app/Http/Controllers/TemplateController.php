<?php

namespace App\Http\Controllers;

use App\Models\Templates;
use App\Models\UserTemplate;
use App\Models\UserWebsite;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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

    public function publish(Request $request) {
        if (!isset($request['html']) || !isset($request['css']) || !isset($request['id'])|| !isset($request['user_id']) || !isset($request['name'])) {
           return \response('', 400);
        }

        $html = $request['html'];
        $css = $request['css'];
        $id = $request['id'];
        $name = $request['name'];
        $userId = $request['user_id'];

        DB::transaction(function() use ($html, $css, $id, $userId, $name) {
            UserWebsite::create([
                'html' => $html,
                'css' => $css,
                'user_template_id' => $id,
                'user_id' => $userId,
                'name' => $name,
                'active' => 0,
            ]);
        });



        $data = ['message' => 'Success!'];
        return response()->json($data, 201);

    }
}
