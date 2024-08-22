<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function Psy\debug;

class UserPublicProfileJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'detail' => [
                'id' => $this->resource->id,
                'bio' => $this->resource->bio,
                'type' => $this->resource->screenName->screen_nameable_type,
                'screen_name' => $this->resource->screenName->screen_name,
                'teams' => $this->resource->allTeams(),
                'name' => $this->resource->name,
                'photo_url' => $this->resource->profile_photo_url,
                'links' => collect($this->resource->links)->map(function ($link) {
                    return [
                        'label' => $link['label'],
                        'link' => $link['link'],
                    ];
                }),
                'followers_count' => $this->resource->followers_count,
                'content' => '',
                'tags' => $this->resource->tags->map(function ($tag) {
                    return $tag->name;
                }),
            ],
            'auth_user' => [
                'is_followed' => $this->resource->is_followed,
            ],
        ];
    }
}
