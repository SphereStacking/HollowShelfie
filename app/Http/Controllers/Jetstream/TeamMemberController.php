<?php

namespace App\Http\Controllers\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Jetstream;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Laravel\Jetstream\Contracts\AddsTeamMembers;
use Laravel\Jetstream\Actions\UpdateTeamMemberRole;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Contracts\RemovesTeamMembers;

class TeamMemberController extends Controller
{
    /**
     * Add a new team member to a team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request,Team $team)
    {
        if (Features::sendsTeamInvitations()) {
            app(InvitesTeamMembers::class)->invite(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        } else {
            app(AddsTeamMembers::class)->add(
                $request->user(),
                $team,
                $request->email ?: '',
                $request->role
            );
        }

        return back(303);
    }

    /**
     * Update the given team member's role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team  $team
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Team $team,User $user)
    {
        Log::info('update');
        app(UpdateTeamMemberRole::class)->update(
            $request->user(),
            $team,
            $user->id,
            $request->role
        );

        return back(303);
    }

    /**
     * Remove the given user from the given team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Team  $team
     * @param  User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, Team $team, User $user)
    {

        app(RemovesTeamMembers::class)->remove(
            $request->user(),
            $team,
            $user
        );

        if ($request->user()->id === $user->id) {
            return redirect(config('fortify.home'));
        }

        return back(303);
    }
}
