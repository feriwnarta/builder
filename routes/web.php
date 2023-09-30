<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\TemplateController;
use App\Livewire\Admin\AddComponent\AddComponent;
use App\Livewire\Admin\Admin;
use App\Livewire\Admin\ComponentCategory\AddComponentCategory;
use App\Livewire\Builder\Builder;
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



Route::controller(AdminController::class)->group(function() {
    Route::get('/admin', Admin::class);
    Route::get('/admin/add-component', AddComponent::class);
    Route::get('/admin/add-component-category', AddComponentCategory::class);
});

Route::controller(TemplateController::class)->group(function () {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
});
