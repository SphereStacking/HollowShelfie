<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\MarkdownPageController;

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

Route::get('/about/{about}', [MarkdownPageController::class, 'showAbout'])->name('about');
Route::get('/guide/{guides}', [MarkdownPageController::class, 'showGuides'])->name('guide');
Route::get('/legal/{legal}', [MarkdownPageController::class, 'showLegal'])->name('legal');
