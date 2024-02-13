<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\TeamLogoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventGoodController;
use App\Http\Controllers\EventBookmarkController;

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

// Sample CRUD operations
// Route::get('/sample', [SampleController::class, 'index'])->name('sample.index');
// Route::get('/sample/create', [SampleController::class, 'create'])->name('sample.create');
// Route::post('/sample', [SampleController::class, 'store'])->name('sample.store');
// Route::get('/sample/{sample}', [SampleController::class, 'show'])->name('sample.show');
// Route::get('/sample/{sample}/edit', [SampleController::class, 'edit'])->name('sample.edit');
// Route::put('/sample/{sample}', [SampleController::class, 'update'])->name('sample.update');
// Route::delete('/sample/{sample}', [SampleController::class, 'destroy'])->name('sample.destroy');

// Route::resourceはつかはない。
// ルートとメソッドの管理がしにくい。

Route::get('/phpinfo', function () {
    phpinfo();
});

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/welcome', [WelcomeController::class, 'welcome'])
    ->name('welcome');

Route::get('/credits', function () {
    return Inertia::render('Credits/Index');
})->name('credits');


Route::get('/user/{user:alias_name}', [ProfileController::class, 'user'])
    ->name('user.profile.show');

Route::get('/team/{team:alias_name}', [ProfileController::class, 'team'])
    ->name('team.profile.show');


Route::get('/event', [EventController::class, 'index'])
    ->name('event.index');

Route::get('/event/search', [SearchController::class, 'event'])
    ->name('event.search.index');
Route::get('/user/search', [SearchController::class, 'user'])
    ->name('user.search.index');


Route::get('/tag/suggestion', [SearchController::class, 'tagSuggestion'])
    ->name('tag.suggestion');
Route::get('/mention/search', [SearchController::class, 'mentionSuggestion'])
    ->name('mention.suggestion');

//ログインしていない場合login画面に遷移
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/user/{user:alias_name}/bookmark', [EventBookmarkController::class, 'bookmark'])->name('dashboard.bookmark');
    Route::get('/user/{user:alias_name}/good', [EventGoodController::class, 'good'])->name('user.good');
    Route::get('/user/{user:alias_name}/following', [FollowController::class, 'following'])->name('user.following');
    Route::get('/user/{user:alias_name}/follower', [FollowController::class, 'follower'])->name('user.follower');



    Route::delete('/team/{team}/logo', [TeamLogoController::class, 'destroy'])->name('current-team-logo.destroy');
    Route::put('/team/{team}/logo', [TeamLogoController::class, 'update'])->name('current-team-logo.update');

    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::get('/event/recruiting', [EventController::class, 'recruiting'])->name('event.recruiting');

    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{event}/show', [EventController::class, 'show'])->name('event.show');
    // Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit'); // Edit form
    // Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update'); // Update existing event
    // Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy'); // Delete event

    Route::post('/event/{event}/good', [EventGoodController::class, 'store'])->name('event.good');
    Route::delete('/event/{event}/good', [EventGoodController::class, 'destroy'])->name('event.ungood');
    Route::post('/event/{event}/bookmark', [EventBookmarkController::class, 'store'])->name('event.bookmark');
    Route::delete('/event/{event}/bookmark', [EventBookmarkController::class, 'destroy'])->name('event.unbookmark');

    Route::get('/event/timeline', [EventController::class, 'timeline'])->name('event.timeline.show');
});

// Route::get('/information', [InformationController::class, 'index'])->name('information.index');
