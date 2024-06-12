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
            'type' => 'team',
            'dataile' => [
                'id' => $this->resource->id,
                'screen_name' => $this->resource->screenName->screen_name,
                'name' => $this->resource->name,
                'photo_url' => $this->resource->team_logo_url,
                'owner' => [
                    'profile_url' => $this->resource->owner->profile_url,
                    'id' => $this->resource->owner->id,
                    'image_url' => $this->resource->owner->profile_photo_url,
                    'name' => $this->resource->owner->name,
                ],
                'members' => $this->resource->members->map(function ($member) {
                    return [
                        'profile_url' => $member->profile_url,
                        'id' => $member->id,
                        'image_url' => $member->profile_photo_url,
                        'name' => $member->name,
                    ];
                }),

                'location' => 'TODO',
                'links' => $this->resource->links->map(function ($link) {
                    return [
                        'label' => $link->label,
                        'link' => $link->link,
                    ];
                }),
                'followers_count' => $this->resource->followers_count,
                'content' => '',
                'tags' => $this->resource->tags->map(function ($tag) {
                    return [
                        'name' => $tag->name,
                    ];
                }),
            ],
            'auth_user' => [
                'is_followed' => $this->resource->is_followed,
            ],
        ];
    }
}
