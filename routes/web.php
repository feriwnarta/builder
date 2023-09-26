<?php

use App\Livewire\Builder\Builder;
use App\Livewire\Sidebar\SidebarLeftContent;
use App\Models\Template;
use App\Models\Templates;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Builder::class);
Route::get('/posts', SidebarLeftContent::class);

Route::post('/template', function () {
    header("Content-Type:application/json");
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data)) {
        $id = $data['id'];
        $data =  $data['data'];
    }
});

Route::get('/template/{id}', function ($id) {
    echo '{
        "assets": [],
        "styles": [
            {
                "selectors": [
                    "txt-red"
                ],
                "style": {
                    "color": "#ffaa00"
                }
            }
        ],
        "pages": [
            {
                "frames": [
                    {
                        "component": {
                            "type": "wrapper",
                            "stylable": [
                                "background",
                                "background-color",
                                "background-image",
                                "background-repeat",
                                "background-attachment",
                                "background-position",
                                "background-size"
                            ],
                            "attributes": {
                                "id": "i1fy"
                            },
                            "components": [
                                {
                                    "type": "text",
                                    "classes": [
                                        "txt-red"
                                    ],
                                    "components": [
                                        {
                                            "type": "textnode",
                                            "content": "Hello world!sadasd"
                                        }
                                    ]
                                }
                            ]
                        },
                        "id": "vDFzgBWMNXHTsbm2"
                    }
                ],
                "id": "WYdEV92XnCaNgWYl"
            }
        ]
    }';
});

Route::get('test', function () {


    $template = Templates::where('id', '9a395d75-0248-447b-aedb-7fcfe88948de')
        ->whereHas('user', function ($query) {
            $query->where('id', '9as395c55-373a-45e0-b22f-f5e630d3be58');
        })
        ->first();
    var_dump($template);
});

Route::post('/project/save', function ($id) {
    echo 'asd';
});
