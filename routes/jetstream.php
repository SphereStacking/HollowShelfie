<?php

use App\Http\Controllers\Jetstream\TeamController;
use App\Http\Controllers\Jetstream\TeamMemberController;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\CurrentTeamController;
use Laravel\Jetstream\Http\Controllers\TeamInvitationController;
use Laravel\Jetstream\Http\Controllers\Inertia\ApiTokenController;
use Laravel\Jetstream\Http\Controllers\Inertia\CurrentUserController;
use Laravel\Jetstream\Http\Controllers\Inertia\UserProfileController;
use Laravel\Jetstream\Http\Controllers\Inertia\ProfilePhotoController;
use Laravel\Jetstream\Http\Controllers\Inertia\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Inertia\TermsOfServiceController;
use Laravel\Jetstream\Http\Controllers\Inertia\OtherBrowserSessionsController;

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    // if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
    //     Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
    //     Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
    // }

    $authMiddleware = config('jetstream.guard')
        ? 'auth:'.config('jetstream.guard')
        : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // User & Profile...
        Route::get('/account/profile', [UserProfileController::class, 'show'])
            ->name('profile.show');

        Route::delete('/account/other-browser-sessions', [OtherBrowserSessionsController::class, 'destroy'])
            ->name('other-browser-sessions.destroy');

        Route::delete('/account/profile-photo', [ProfilePhotoController::class, 'destroy'])
            ->name('current-user-photo.destroy');

        if (Jetstream::hasAccountDeletionFeatures()) {
            Route::delete('/account', [CurrentUserController::class, 'destroy'])
                ->name('current-user.destroy');
        }

        Route::group(['middleware' => 'verified'], function () {
            // API...
            if (Jetstream::hasApiFeatures()) {
                Route::get('/account/api-tokens', [ApiTokenController::class, 'index'])->name('api-tokens.index');
                Route::post('/account/api-tokens', [ApiTokenController::class, 'store'])->name('api-tokens.store');
                Route::put('/account/api-tokens/{token}', [ApiTokenController::class, 'update'])->name('api-tokens.update');
                Route::delete('/account/api-tokens/{token}', [ApiTokenController::class, 'destroy'])->name('api-tokens.destroy');
            }

            // Teams...
            Route::group(['middleware' => 'permission:feature-team'], function () {
                Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
                Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
                Route::put('/teams/{team:screen_name}', [TeamController::class, 'update'])->name('teams.update');
                Route::delete('/teams/{team:screen_name}', [TeamController::class, 'destroy'])->name('teams.destroy');
                Route::post('/teams/{team:screen_name}/members', [TeamMemberController::class, 'store'])->name('team-members.store');
                Route::put('/teams/{team:screen_name}/members/{user:screen_name}', [TeamMemberController::class, 'update'])->name('team-members.update');
                Route::delete('/teams/{team:screen_name}/members/{user:screen_name}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');
            });
            Route::put('/current-team', [CurrentTeamController::class, 'update'])->name('current-team.update');
            Route::get('/teams/{team:screen_name}', [TeamController::class, 'show'])->name('teams.show');
            Route::get('/team-invitations/{invitation}', [TeamInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('team-invitations.accept');

            Route::delete('/team-invitations/{invitation}', [TeamInvitationController::class, 'destroy'])
                ->name('team-invitations.destroy');
        });
    });
});
