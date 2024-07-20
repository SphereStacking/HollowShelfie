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
        $allTeams = $userHasTeamFeatures ? $user->allTeams()->values() : null;
        $twoFactorEnabled = Features::enabled(Features::twoFactorAuthentication()) && !is_null($user->two_factor_secret);
        $screenName = $user->screenName->screen_name;

        // ユーザーの全ての権限を収集
        $permissions = $user->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique()->toArray();

        return [
            'user' => array_merge($user->toArray(),[
                'all_teams' => $allTeams,
                'permissions' => $permissions,
                'two_factor_enabled' => $twoFactorEnabled,
                'screen_name' => $screenName,
            ]),
        ];
    }
}
