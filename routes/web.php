<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\StartProjectController;

Route::get('/', function () {
    return view('index');
});

// Blog Routes (Frontend - Public)
Route::get('/blog', [PostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('blog.show');
Route::get('/investment-opportunities', [PostController::class, 'opportunities'])->name('blog.opportunities');

// Portfolio Routes (Frontend - Public)
Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/portfolio/{portfolio:slug}', [PortfolioController::class, 'show'])->name('portfolio.show');

// Static Pages Routes
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/start-your-project', function () {
    return view('start-your-project');
})->name('start-your-project');


// منع الوصول إلى صفحة التسجيل وإعادة التوجيه إلى صفحة تسجيل الدخول
Route::get('/register', function () {
    return redirect()->route('login');
})->middleware(['basic.auth']);

Route::post('/register', function () {
    abort(403, 'التسجيل غير متاح حالياً');
})->middleware(['basic.auth']);

// Admin Routes (protected)
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Admin Dashboard
        Route::get('/', function () {
            return view('dashboard');
        })->name('dashboard')->middleware('permission:access dashboard');

        // Admin image upload routes
        Route::post('/upload/image', [ImagesController::class, 'upload'])
            ->name('images.upload')
            ->middleware('permission:manage content');

        Route::post('/ckeditor/upload', [ImagesController::class, 'ckeditorUpload'])
            ->name('ckeditor.upload')
            ->middleware('permission:manage content');

        // Admin Posts Management
        Route::resource('posts', AdminPostController::class)
            ->middleware('permission:manage content');

        Route::post('posts/upload-image', [AdminPostController::class, 'uploadImage'])
            ->name('posts.upload-image')
            ->middleware('permission:manage content');

        // Admin Portfolio Management
        Route::resource('portfolio', AdminPortfolioController::class)
            ->middleware('permission:manage content');
    });

// Special route for clearing temporary images that doesn't follow the admin. prefix pattern
Route::post('/admin/posts/clear-temp-images', [AdminPostController::class, 'clearTempImages'])
    ->name('admin.posts.clear-temp-images')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin', 'permission:manage content']);

// Redirect /dashboard to /admin
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin'])->name('dashboard');

// Contact Routes
Route::post('/contact/submit', [ContactController::class, 'submit'])
    ->name('contact.submit')
    ->middleware(['web']);

// Contact Page Form Route
Route::post('/contact-page/submit', [ContactPageController::class, 'submit'])
    ->name('contact.page.submit')
    ->middleware(['web']);

// Investment Routes
Route::post('/investment/submit', [InvestmentController::class, 'submit'])
    ->name('investment.submit')
    ->middleware(['web']);

// Start Project Route
Route::post('/start-project/submit', [StartProjectController::class, 'submit'])
    ->name('start.project.submit')
    ->middleware(['web']);
