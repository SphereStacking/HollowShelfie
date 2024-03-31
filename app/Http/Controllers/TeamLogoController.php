<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TeamLogoController extends Controller
{
    /**
     * Update the current Team's logo.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Team $team)
    {
        if (isset($request['logo'])) {
            $team->updateTeamLogo($request['logo']);
        }

        return back(303)->with('status', 'team-logo-updated');
    }

    /**
     * Delete the current Team's logo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Team $team)
    {
        $team->deleteTeamLogo();

        return back(303)->with('status', 'team-logo-deleted');
    }
}
