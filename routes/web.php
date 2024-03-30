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
use App\Models\TemplateRepository;
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


Route::get('form', \App\Livewire\Form::class);
Route::get('/', LandingPage::class);
Route::get('/sign-in', Login::class);
Route::get('/sign-up', Register::class);
Route::get('/test', function () {
    $id = '7cfce10a-28e7-43a7-8daf-e7053e14cc1f';
});


// Rute untuk pengguna biasa
    Route::get('/builder', Builder::class);
    Route::get('/dashboard', function () {
        return 'user';
    });

Route::get('/admins/builder', Builder::class);
Route::get('/admins/dashboard', Dashboard::class);
Route::get('/admins/add-component', AddComponent::class);
Route::get('/admins/add-component-category', AddComponentCategory::class);
Route::get('/admins/template', AllTemplate::class);

Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        dd('asd');
    })->name('users');
});

Route::controller(TemplateController::class)->group(function () {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
});
