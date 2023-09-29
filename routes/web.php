<?php

use App\Http\Controllers\TemplateController;
use App\Livewire\Builder\Builder;
use App\Models\Templates;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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


Route::controller(TemplateController::class)->group(function () {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
});

Route::get('/test', function () {

    $templates = Templates::find('9a375-0248-447b-aedb-7fcfe88948de');

    if ($templates == null) {
        echo 'nukll';
    }
});
