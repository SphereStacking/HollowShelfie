<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FollowController extends Controller
{
    //
    public function followUser(User $user)
    {
        auth()->user()->follows()->syncWithoutDetaching($user->id, ['followable_type' => User::class]);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$user->name}をフォローしました。"
        ]);
    }

    // ユーザーのフォロー解除
    public function unfollowUser(User $user)
    {
        auth()->user()->follows()->detach($user->id, ['followable_type' => User::class]);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$user->name}のフォローを解除しました。"
        ]);
    }


    public function followTeam(Team $team)
    {
        auth()->user()->follows()->syncWithoutDetaching($team->id, ['followable_type' => Team::class]);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$team->name}をフォローしました。"
        ]);
    }



    // チームのフォロー解除
    public function unfollowTeam(Team $team)
    {
        auth()->user()->follows()->detach($team->id, ['followable_type' => Team::class]);
        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$team->name}のフォローを解除しました。"
        ]);
    }
}
