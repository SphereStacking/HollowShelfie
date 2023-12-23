<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FollowController;

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

    // ユーザーをフォロー
    Route::post('/users/{user}/follow', [FollowController::class, 'followUser'])
        ->name('users.follow');
    // チームjをフォロー
    Route::post('/teams/{team}/follow', [FollowController::class, 'followTeam'])
        ->name('teams.follow');
    // ユーザーのフォロー解除
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'unfollowUser'])
        ->name('users.unfollow');
    // チームのフォロー解除
    Route::delete('/teams/{team}/unfollow', [FollowController::class, 'unfollowTeam'])
        ->name('teams.unfollow');
});
