<?php

use App\Http\Controllers\Follow\DestroyFollowController;
use App\Http\Controllers\Follow\DestroyTeamFollowController;
use App\Http\Controllers\Follow\DestroyUserFollowController;
use App\Http\Controllers\Follow\StoreFollowController;
use App\Http\Controllers\Follow\StoreTeamFollowController;
use App\Http\Controllers\Follow\StoreUserFollowController;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // フォロー
    Route::post('/follow', StoreFollowController::class)->name('follow');
    // フォロー解除
    Route::delete('/unfollow', DestroyFollowController::class)->name('unfollow');

    // ユーザーをフォロー
    Route::post('/users/{user}/follow', StoreUserFollowController::class)->name('users.follow');
    // チームjをフォロー
    Route::post('/teams/{team}/follow', StoreTeamFollowController::class)->name('teams.follow');

    // ユーザーのフォロー解除
    Route::delete('/users/{user}/unfollow', DestroyUserFollowController::class)->name('users.unfollow');
    // チームのフォロー解除
    Route::delete('/teams/{team}/unfollow', DestroyTeamFollowController::class)->name('teams.unfollow');
});
