<?php

use App\Http\Controllers\TemplateController;
use App\Livewire\Builder\Builder;
use App\Livewire\Sidebar\SidebarLeftContent;
use App\Models\Component;
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


Route::controller(TemplateController::class)->group(function() {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
});

