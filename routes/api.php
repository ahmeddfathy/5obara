<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PortfolioController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InvestmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Portfolio routes
Route::get('/portfolios', [PortfolioController::class, 'index']);
Route::get('/portfolios/{portfolio}', [PortfolioController::class, 'show']);
Route::get('/portfolio-categories', [PortfolioController::class, 'categories']);

// Blog routes
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{blog}', [BlogController::class, 'show']);
Route::get('/blog-categories', [BlogController::class, 'categories']);
Route::get('/blog-types', [BlogController::class, 'blogTypes']);
Route::get('/blogs/by-type', [BlogController::class, 'byType']);
Route::get('/featured-blogs', [BlogController::class, 'featured']);

// Contact route
Route::post('/contact', [ContactController::class, 'submit'])->middleware(['throttle:20,1']);

// Investment form submission route
Route::post('/investments', [InvestmentController::class, 'submit'])->middleware(['throttle:10,10']);
