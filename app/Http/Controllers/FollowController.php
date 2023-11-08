<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FollowController extends Controller
{
    //
    public function followUser(User $user)
    {
        auth()->user()->follows()->attach($user->id, ['followable_type' => 'App\Models\User']);

        return back()->with('success', 'ユーザーをフォローしました！');
    }

    public function followTeam(Team $team)
    {
        auth()->user()->follows()->attach($team->id, ['followable_type' => 'App\Models\Team']);

        return back()->with('success', 'チームをフォローしました！');
    }

    // ユーザーのフォロー解除
    public function unfollowUser(User $user)
    {
        auth()->user()->follows()->detach($user->id, ['followable_type' => 'App\Models\User']);
        return back()->with('success', 'ユーザーのフォローを解除しました。');
    }

    // チームのフォロー解除
    public function unfollowTeam(Team $team)
    {
        auth()->user()->follows()->detach($team->id, ['followable_type' => 'App\Models\Team']);
        return back()->with('success', 'チームのフォローを解除しました。');
    }
}
