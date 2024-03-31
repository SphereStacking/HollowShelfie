<?php

namespace App\Http\Controllers\TeamLogo;

use App\Models\Team;
use Illuminate\Routing\Controller;

class DestroyTeamLogoController extends Controller
{
    public function __invoke(Team $team)
    {
        $team->deleteTeamLogo();

        return back(303)->with('status', 'team-logo-deleted');
    }
}
