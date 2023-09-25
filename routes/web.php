<?php

use App\Livewire\Builder\Builder;
use App\Models\Template;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

Route::post('/template', function () {
    header("Content-Type:application/json");
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data)) {
        $id = $data['id'];
        $data =  $data['data'];


        Template::create([
            'template_id' => $id,
            'data' => $data,
        ]);

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


Route::post('/project/save', function ($id) {
    echo 'asd';
});
