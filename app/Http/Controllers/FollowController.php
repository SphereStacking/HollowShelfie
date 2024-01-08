<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class FollowController extends Controller
{
    /**
     * 指定されたユーザーをフォローします。
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function followUser(User $user)
    {
        $user->follow($user);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$user->name}をフォローしました。"
        ]);
    }

    /**
     * 指定されたユーザーのフォローを解除します。
     *
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfollowUser(User $user)
    {
        $user->unfollow($user);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$user->name}のフォローを解除しました。"
        ]);
    }

    /**
     * 指定されたチームをフォローします。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function followTeam(Team $team)
    {
        $team->follow($team);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$team->name}をフォローしました。"
        ]);
    }

    /**
     * 指定されたチームのフォローを解除します。
     *
     * @param  Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfollowTeam(Team $team)
    {
        $team->unfollow($team);

        return Redirect::back()->with([
            'status' => 'success',
            'message' => "{$team->name}のフォローを解除しました。"
        ]);
    }
}
