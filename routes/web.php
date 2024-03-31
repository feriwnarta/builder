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

Route::domain('{web}.' . 'localhost')->group(function ($web) {
    Route::get('/view', function ($web) {
        $userWebsite = \App\Models\UserWebsite::where('name', $web)
            ->where('active', 1)
            ->first();

        if(is_null($userWebsite)) {
            return 'web is not active';
        }

        // Extract HTML and CSS from database
        $html = $userWebsite->html;
        $css = $userWebsite->css;

        // Check if CSS exists and append it to the head section
        if (!empty($css)) {
            // Find the position of </head> tag
            $pos = strpos($html, '</head>');

            // Insert CSS before </head> tag
            if ($pos !== false) {
                $html = substr_replace($html, "<style>$css</style>", $pos, 0);
            } else {
                // If </head> tag is not found, just append CSS at the end
                $html .= "<style>$css</style>";
            }
        }

        return $html;

    });
});

Route::controller(TemplateController::class)->group(function () {
    Route::post('/template', 'saveTemplate');
    Route::get('/template/{template}', 'findTemplate');
    Route::post('/publish', 'publish');
});
