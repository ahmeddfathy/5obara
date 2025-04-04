<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ImagesController;

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

// Route::get('/portfolio', function () {
//     return view('prtofolio');
// })->name('portfolio');

// Admin Routes (protected)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Admin image upload routes
    Route::post('/upload/image', [ImagesController::class, 'upload'])->name('images.upload');
    Route::post('/ckeditor/upload', [ImagesController::class, 'ckeditorUpload'])->name('ckeditor.upload');

    // Admin Posts Management
    Route::resource('posts', AdminPostController::class);

    // Admin Portfolio Management
    Route::resource('portfolio', AdminPortfolioController::class);

    // مسار اختبار CKEditor
    Route::get('/ckeditor-test', function () {
        return view('admin.posts.ckeditor_test');
    })->name('ckeditor.test');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
