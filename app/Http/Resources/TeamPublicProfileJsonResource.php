<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamPublicProfileJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'dataile' => [
                'id' => $this->resource->id,
                'screen_name' => $this->resource->screen_name,
                'name' => $this->resource->name,
                'photo_url' => $this->resource->team_logo_url,
                'profile_url' => route('user.profile.show', $this->resource->id),
                'location' => 'TODO',
                'links' => $this->resource->links->map(function ($link) {
                    return [
                        'label' => $link->label,
                        'link' => $link->link,
                    ];
                }),
                'followers_count' => $this->resource->followers_count,
                'content' => 'hogegegege',
                'tags' => $this->resource->tags->map(function ($tag) {
                    return [
                        'name' => $tag->name,
                    ];
                }),
                'badges' => $this->resource->badges->map(function ($badge) {
                    return [
                        'name' => $badge->name,
                        'icon_class' => $badge->icon_class,
                    ];
                }),
            ],
            'auth_user' => [
                'is_followed' => $this->resource->is_followed,
            ],
        ];
    }
}
