<?php


use App\Http\Controllers\TemplateController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Livewire\Admin\AddComponent\AddComponent;
use App\Livewire\Admin\ComponentCategory\AddComponentCategory;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Template\AllTemplate;
use App\Livewire\Builder\Builder;
use App\Livewire\LandingPage\Authentication\Login;
use App\Livewire\LandingPage\Authentication\Register;
use App\Livewire\LandingPage\LandingPage;
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


Route::get('/', LandingPage::class);
Route::get('/sign-in', Login::class);
Route::get('/sign-up', Register::class);




// Rute untuk pengguna biasa
Route::middleware([UserMiddleware::class])->group(function () {
    Route::get('/builder', Builder::class);
    Route::get('/dashboard', function () {
        return 'user';
    });
});


Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/builder', Builder::class);
    Route::get('/admin/dashboard', Dashboard::class);
    Route::get('/admin/add-component', AddComponent::class);
    Route::get('/admin/add-component-category', AddComponentCategory::class);
    Route::get('/admin/template', AllTemplate::class);
});

// Rute khusus untuk admin


Route::controller(TemplateController::class)->group(function () {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
});
