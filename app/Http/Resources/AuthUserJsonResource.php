<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Fortify\Features;
use Laravel\Jetstream\Jetstream;

class AuthUserJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $request->user();

        if (!$user) {
            return [];
        }

        $userHasTeamFeatures = Jetstream::userHasTeamFeatures($user);

        if ($user && $userHasTeamFeatures) {
            $user->currentTeam;
        }

        return [
            'user' => array_merge($user->toArray(), array_filter([
                'all_teams' => $userHasTeamFeatures ? $user->allTeams()->values() : null,
            ]), [
                'two_factor_enabled' => Features::enabled(Features::twoFactorAuthentication())
                    && !is_null($user->two_factor_secret),
                'screen_name' => $user->screenName->screen_name,
            ]),
        ];
    }
}
