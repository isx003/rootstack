<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClassifiedController;

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
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/categories', [ClassifiedController::class, 'categories'])
    ->middleware(['auth'])
    ->name('categories');

Route::get('/crawler-by-slug', [ClassifiedController::class, 'crawlerBySlug'])
    ->middleware(['auth']);

require __DIR__.'/auth.php';
