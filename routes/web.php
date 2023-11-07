<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamLogoController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\PerformerController;

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

Route::get('/phpinfo', function () {
    phpinfo();
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('/credits', function () {
    return Inertia::render('Credits/Index');
})->name('credits');

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

Route::get('/user/{user}', [ProfileController::class, 'userProfileShow'])
    ->name('user.profile.show');

Route::get('/team/{team}', [ProfileController::class, 'teamProfileShow'])
    ->name('team.profile.show');

//ログインしていない場合login画面に遷移
Route::middleware(['auth:sanctum', 'verified'])->group(function () {


    Route::get('/organizer/{organizer}/show', [OrganizerController::class, 'show'])->name('organizer.show');
    Route::get('/performer/{performer}/show', [PerformerController::class, 'show'])->name('performer.show');
    Route::delete('/team/{team}/logo', [TeamLogoController::class, 'destroy'])->name('current-team-logo.destroy');
    Route::put('/team/{team}/logo', [TeamLogoController::class, 'update'])->name('current-team-logo.update');

    // Event CRUD operations
    Route::get('/event', [EventController::class, 'index'])->name('event.index');
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/{event}/show', [EventController::class, 'show'])->name('event.show');
    // Route::get('/event/{event}/edit', [EventController::class, 'edit'])->name('event.edit'); // Edit form
    // Route::put('/event/{event}', [EventController::class, 'update'])->name('event.update'); // Update existing event
    // Route::delete('/event/{event}', [EventController::class, 'destroy'])->name('event.destroy'); // Delete event

    // Event "Good" and "Like" operation

    Route::post('/event/{event}/good/toggle', [EventController::class, 'toggleEventGood'])->name('event.good.toggle');
    Route::post('/event/{event}/like/toggle', [EventController::class, 'toggleEventLike'])->name('event.like.toggle');

    // Event List
    Route::get('/event/list', [EventController::class, 'list'])->name('event.list.index');

    Route::get('/event/timeline', [EventController::class, 'timeline'])->name('event.timeline.show');
});

// Route::get('/information', [InformationController::class, 'index'])->name('information.index');
