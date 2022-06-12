<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
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
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
	Route::get('/', [ImageController::class, 'index'])->name('images.index');

	Route::get('/upload', [ImageController::class, 'uploadView'])->name('images.upload-show');
	Route::post('/upload', [ImageController::class, 'store'])->name('images.store');

	Route::get('/{image:hash}', [ImageController::class, 'show'])->name('images.show');

	Route::post('/{image:hash}/react/{reaction}', [ImageController::class, 'react'])->name('images.react');
});

