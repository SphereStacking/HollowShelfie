<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetHomeController;
use App\Http\Controllers\GetWelcomeController;
use App\Http\Controllers\GetDashboardController;
use App\Http\Controllers\Event\ShowEventController;
use App\Http\Controllers\Event\StoreEventController;
use App\Http\Controllers\GetTagSuggestionController;
use App\Http\Controllers\Event\UpdateEventController;
use App\Http\Controllers\EventGood\GetGoodController;
use App\Http\Controllers\Event\DestroyEventController;
use App\Http\Controllers\Event\GetEditEventController;
use App\Http\Controllers\Follow\GetFollowerController;
use App\Http\Controllers\User\GetUserSearchController;
use App\Http\Controllers\Event\GetIndexEventController;
use App\Http\Controllers\EventGood\StoreGoodController;
use App\Http\Controllers\Follow\GetFollowingController;
use App\Http\Controllers\Event\GetCreateEventController;
use App\Http\Controllers\Event\GetEventSearchController;
use App\Http\Controllers\Event\GetManageEventController;
use App\Http\Controllers\GetMentionSuggestionController;
use App\Http\Controllers\EventGood\DestroyGoodController;
use App\Http\Controllers\Event\GetTimeLineEventController;
use App\Http\Controllers\Profile\GetTeamProfileController;
use App\Http\Controllers\Profile\GetUserProfileController;
use App\Http\Controllers\TeamLogo\StoreTeamLogoController;
use App\Http\Controllers\Event\GetRecruitingEventController;
use App\Http\Controllers\TeamLogo\DestroyTeamLogoController;
use App\Http\Controllers\EventBookmark\GetBookmarkController;
use App\Http\Controllers\EventFryer\StoreEventFryerController;
use App\Http\Controllers\EventBookmark\StoreBookmarkController;
use App\Http\Controllers\EventFryer\DestroyEventFryerController;
use App\Http\Controllers\EventBookmark\DestroyBookmarkController;


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


Route::get('/home', GetHomeController::class)->name('home');
Route::get('/', GetWelcomeController::class)
    ->name('welcome');

Route::get('/credits', function () {
    return Inertia::render('Credits/Index');
})->name('credits');


Route::get('/user/{user:alias_name}', GetUserProfileController::class)
    ->name('user.profile.show');

Route::get('/team/{team:alias_name}', GetTeamProfileController::class)
    ->name('team.profile.show');

Route::get('/event', GetIndexEventController::class)
    ->name('event.index');

Route::get('/event/search', GetEventSearchController::class)
    ->name('event.search.index');

Route::get('/user/search', GetUserSearchController::class)
    ->name('user.search.index');

Route::get('/tag/suggestion', GetTagSuggestionController::class)
    ->name('tag.suggestion');
Route::get('/mention/search', GetMentionSuggestionController::class)
    ->name('mention.suggestion');

Route::get('/event/{event}/show', ShowEventController::class)->name('event.show');

//ログインしていない場合login画面に遷移
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', GetDashboardController::class)->name('dashboard');
    Route::get('/user/{user:alias_name}/bookmark', GetBookmarkController::class, 'bookmark')->name('user.bookmark');
    Route::get('/user/{user:alias_name}/good', GetGoodController::class, 'good')->name('user.good');
    Route::get('/user/{user:alias_name}/following', GetFollowingController::class)->name('user.following');
    Route::get('/user/{user:alias_name}/follower', GetFollowerController::class)->name('user.follower');

    Route::delete('/team/{team}/logo', DestroyTeamLogoController::class)->name('current-team-logo.destroy');
    Route::put('/team/{team}/logo', StoreTeamLogoController::class)->name('current-team-logo.update');

    Route::get('/event/recruiting', GetRecruitingEventController::class)->name('event.recruiting');
    Route::get('/event/manage', GetManageEventController::class)->name('event.manage');

    Route::put('/event', StoreEventController::class)->name('event.store');
    Route::delete('/event/fryer', DestroyEventFryerController::class)->name('event.fryer.destroy');
    Route::get('/event/create', GetCreateEventController::class)->name('event.create');
    Route::get('/event/{event}/edit', GetEditEventController::class)->name('event.edit');
    Route::put('/event/{event}', UpdateEventController::class)->name('event.update');
    Route::delete('/event/{event}', DestroyEventController::class)->name('event.destroy');
    Route::put('/event/{event}/fryer', StoreEventFryerController::class)->name('event.fryer.store');

    Route::post('/event/{event}/good', StoreGoodController::class)->name('event.good');
    Route::delete('/event/{event}/good', DestroyGoodController::class)->name('event.ungood');
    Route::post('/event/{event}/bookmark', StoreBookmarkController::class)->name('event.bookmark');
    Route::delete('/event/{event}/bookmark', DestroyBookmarkController::class)->name('event.unbookmark');

    Route::get('/event/timeline', GetTimeLineEventController::class)->name('event.timeline.show');
});

// Route::get('/information', [InformationController::class, 'index'])->name('information.index');
