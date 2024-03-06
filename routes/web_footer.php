<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Markdown\GetAboutPageController;
use App\Http\Controllers\Markdown\GetGuidePageController;
use App\Http\Controllers\Markdown\GetLegalPageController;

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

Route::get('/about/{about}', GetAboutPageController::class)->name('about');
Route::get('/guide/{guides}', GetGuidePageController::class)->name('guide');
Route::get('/legal/{legal}', GetLegalPageController::class)->name('legal');
