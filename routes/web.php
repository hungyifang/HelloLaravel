<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/articles/hot', [\App\Http\Controllers\ArticlesController::class, 'hot'])->name('articles.hot');

Route::get('/articles/draft', [\App\Http\Controllers\ArticlesController::class, 'draft'])->name('articles.draft');

Route::get('/articles/{article}/like', [\App\Http\Controllers\ArticlesController::class, 'like'])->name('articles.like');

Route::resource(name:'articles', controller:\App\Http\Controllers\ArticlesController::class);

Route::get('/', [\App\Http\Controllers\ArticlesController::class, 'index'])->name(name:'root');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
