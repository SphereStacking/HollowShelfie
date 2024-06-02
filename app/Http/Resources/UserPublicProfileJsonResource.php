<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'dataile' => [
                'id' => $this->resource->id,
                'screen_name' => $this->resource->screenName->screen_name,
                'name' => $this->resource->name,
                'photo_url' => $this->resource->profile_photo_url,
                // 'profile_url' => $this->resource->profile_url,
                'location' => $this->resource->location,
                'links' => $this->resource->links,
                'followers_count' => $this->resource->followers_count,
                'content' => 'hogegegege',
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
