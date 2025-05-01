<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\PortfolioController as AdminPortfolioController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\ContactPageController;
use App\Http\Controllers\StartProjectController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\InvestmentOpportunityController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InvestmentCategoryController;

Route::get('/', function () {
    return view('index');
});

// Blog Routes (Frontend - Public)
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{blog:slug}', [BlogController::class, 'show'])->name('blog.show');

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

        // Admin Blogs Management
        Route::resource('blogs', AdminBlogController::class)
            ->middleware('permission:manage content');

        Route::post('blogs/upload-image', [AdminBlogController::class, 'uploadImage'])
            ->name('blogs.upload-image')
            ->middleware('permission:manage content');

        // Admin Portfolio Management
        Route::resource('portfolio', AdminPortfolioController::class)
            ->middleware('permission:manage content');

        // Admin Investment Email Management
        Route::get('/investment-email', [App\Http\Controllers\Admin\InvestmentEmailController::class, 'index'])
            ->name('investment.email')
            ->middleware('permission:manage content');

        Route::post('/investment-email/send', [App\Http\Controllers\Admin\InvestmentEmailController::class, 'send'])
            ->name('investment.send-email')
            ->middleware('permission:manage content');

        // Admin Investment Opportunities Management
        Route::resource('investments', AdminInvestmentController::class)
            ->middleware('permission:manage content');

        Route::post('investments/upload-image', [AdminInvestmentController::class, 'uploadImage'])
            ->name('investments.upload-image')
            ->middleware('permission:manage content');

        // Admin Categories Management
        Route::resource('categories', CategoryController::class);

        // Investment Categories Routes
        Route::resource('investment-categories', InvestmentCategoryController::class);
    });

// Special route for clearing temporary images that doesn't follow the admin. prefix pattern
Route::post('/admin/blogs/clear-temp-images', [AdminBlogController::class, 'clearTempImages'])
    ->name('admin.blogs.clear-temp-images')
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', 'role:admin', 'permission:manage content']);

// Special route for clearing temporary images
Route::post('/admin/investments/clear-temp-images', [AdminInvestmentController::class, 'clearTempImages'])
    ->name('admin.investments.clear-temp-images')
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

// Newsletter Subscription Route
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe')
    ->middleware(['web']);

// Investment Opportunities Routes (Frontend - Public)
Route::get('/investment-opportunities', [InvestmentOpportunityController::class, 'index'])->name('investments.index');
Route::get('/investment-opportunities/{investment:slug}', [InvestmentOpportunityController::class, 'show'])->name('investments.show');
