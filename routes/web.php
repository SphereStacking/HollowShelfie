<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetHomeController;
use App\Http\Controllers\GetWelcomeController;
use App\Http\Controllers\GetDashboardController;
use App\Http\Controllers\Event\ShowEventController;
use App\Http\Controllers\Event\GetRoadmapController;
use App\Http\Controllers\GetTagSuggestionController;
use App\Http\Controllers\Event\UpdateEventController;
use App\Http\Controllers\EventGood\GetGoodController;
use App\Http\Controllers\Event\DestroyEventController;
use App\Http\Controllers\Event\GetEditEventController;
use App\Http\Controllers\Follow\GetFollowerController;
use App\Http\Controllers\Follow\StoreFollowController;
use App\Http\Controllers\Profile\GetProfileController;
use App\Http\Controllers\Event\GetIndexEventController;
use App\Http\Controllers\EventGood\StoreGoodController;
use App\Http\Controllers\Follow\GetFollowingController;
use App\Http\Controllers\Event\GetCreateEventController;
use App\Http\Controllers\Event\GetEventSearchController;
use App\Http\Controllers\Event\GetManageEventController;
use App\Http\Controllers\Follow\DestroyFollowController;
use App\Http\Controllers\GetMentionSuggestionController;
use App\Http\Controllers\EventGood\DestroyGoodController;
use App\Http\Controllers\Markdown\GetAboutPageController;
use App\Http\Controllers\Markdown\GetGuidePageController;
use App\Http\Controllers\Markdown\GetLegalPageController;
use App\Http\Controllers\Event\GetTimeLineEventController;
use App\Http\Controllers\Follow\StoreTeamFollowController;
use App\Http\Controllers\Follow\StoreUserFollowController;
use App\Http\Controllers\Markdown\GetCreditPageController;
use App\Http\Controllers\TeamLogo\StoreTeamLogoController;
use App\Http\Controllers\CustomId\UpdateCustomIdController;
use App\Http\Controllers\Event\GetRecruitingEventController;
use App\Http\Controllers\Follow\DestroyTeamFollowController;
use App\Http\Controllers\Follow\DestroyUserFollowController;
use App\Http\Controllers\TeamLogo\DestroyTeamLogoController;
use App\Http\Controllers\EventBookmark\GetBookmarkController;
use App\Http\Controllers\EventFryer\StoreEventFryerController;
use App\Http\Controllers\EventBookmark\StoreBookmarkController;
use App\Http\Controllers\ScreenName\UpdateScreenNameController;
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

// production環境ではphpinfoを表示しない
if (!App::environment('production')) {
    Route::get('/phpinfo', function () { phpinfo(); });
}

Route::get('/home', GetHomeController::class)->name('home');
Route::get('/', GetWelcomeController::class)->name('welcome');

Route::get('/credits', function () {
    return Inertia::render('Credits/Index');
})->name('credits');

Route::get('/@{screen_name}', GetProfileController::class)->name('profile.show');
Route::get('/event', GetIndexEventController::class)->name('event.index');
Route::get('/event/search', GetEventSearchController::class)->name('event.search.index');
Route::get('/tag/suggestion', GetTagSuggestionController::class)->name('tag.suggestion');
Route::get('/mention/search', GetMentionSuggestionController::class)->name('mention.suggestion');

Route::get('/event/{alias}/show', ShowEventController::class)->name('event.show');
Route::get('/event/timeline', GetTimeLineEventController::class)->name('event.timeline.show');


Route::get('/about/{about}', GetAboutPageController::class)->name('about');
Route::get('/guide/{guides}', GetGuidePageController::class)->name('guide');
Route::get('/legal/{legal}', GetLegalPageController::class)->name('legal');
Route::get('/credit', GetCreditPageController::class)->name('credit');
Route::get('/roadmap', GetRoadmapController::class)->name('roadmap');
//ログインしていない場合login画面に遷移
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {

    Route::get('/dashboard', GetDashboardController::class)->name('dashboard');
    Route::get('/user/{user:screen_name}/bookmark', GetBookmarkController::class)->name('user.bookmark');
    Route::get('/user/{user:screen_name}/good', GetGoodController::class)->name('user.good');
    Route::get('/user/{screen_name}/following', GetFollowingController::class)->name('user.following');
    Route::get('/user/{screen_name}/follower', GetFollowerController::class)->name('user.follower');

    Route::delete('/team/{team:screen_name}/logo', DestroyTeamLogoController::class)->name('current-team-logo.destroy');
    Route::put('/team/{team:screen_name}/logo', StoreTeamLogoController::class)->name('current-team-logo.update');

    Route::get('/event/recruiting', GetRecruitingEventController::class)->name('event.recruiting');
    Route::get('/event/manage', GetManageEventController::class)->name('event.manage');

    Route::delete('/event/fryer', DestroyEventFryerController::class)->name('event.fryer.destroy');
    Route::get('/event/create', GetCreateEventController::class)->name('event.create');
    Route::get('/event/{alias}/edit', GetEditEventController::class)->name('event.edit');
    Route::put('/event/{alias}', UpdateEventController::class)->name('event.update');
    Route::delete('/event/{alias}', DestroyEventController::class)->name('event.destroy');
    Route::put('/event/{alias}/fryer', StoreEventFryerController::class)->name('event.fryer.store');

    Route::post('/event/{alias}/good', StoreGoodController::class)->name('event.good');
    Route::delete('/event/{alias}/good', DestroyGoodController::class)->name('event.ungood');
    Route::post('/event/{alias}/bookmark', StoreBookmarkController::class)->name('event.bookmark');
    Route::delete('/event/{alias}/bookmark', DestroyBookmarkController::class)->name('event.unbookmark');


    // フォロー
    Route::post('/follow', StoreFollowController::class)->name('follow');
    Route::post('/users/{screen_name}/follow', StoreUserFollowController::class)->name('users.follow');
    Route::post('/teams/{screen_name}/follow', StoreTeamFollowController::class)->name('teams.follow');

    // フォロー解除
    Route::delete('/unfollow', DestroyFollowController::class)->name('unfollow');
    Route::delete('/users/{screen_name}/unfollow', DestroyUserFollowController::class)->name('users.unfollow');
    Route::delete('/teams/{screen_name}/unfollow', DestroyTeamFollowController::class)->name('teams.unfollow');

    Route::put('/screen_name/{screen_name}', UpdateScreenNameController::class)->name('screen_name.update');
});

