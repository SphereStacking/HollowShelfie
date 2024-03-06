<?php

namespace App\Http\Controllers\TeamLogo;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StoreTeamLogoController extends Controller
{
    public function __invoke(Request $request, Team $team)
    {
        if (isset($request['logo'])) {
            $team->updateTeamLogo($request['logo']);
        }
        return back(303)->with('status', 'team-logo-updated');
    }
}
