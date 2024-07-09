<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowPaginatedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'first_page_url' => $this->resource->url(1),
                'from' => $this->resource->firstItem(),
                'last_page' => $this->resource->lastPage(),
                'links' => $this->resource->linkCollection(),
                'next_page_url' => $this->resource->nextPageUrl(),
                'path' => $this->resource->path(),
                'per_page' => $this->resource->perPage(),
                'prev_page_url' => $this->resource->previousPageUrl(),
                'to' => $this->resource->lastItem(),
                'total' => $this->resource->total(),
            ],
            'data' => $this->resource->map(function ($item) {
                // UserやTeamをfollowしているためfollowableに入れる。
                return [
                    'followable_id' => $item->followable_id,
                    'followable_type' => $item->followable_type,
                    'followable' => [
                        'name' => $item->followable->name,
                        'screen_name' => $item->followable->screenName->screen_name,
                        'profile_url' => $item->followable->profile_url,
                        'image_url' => $item->followable_type === User::class
                            ? $item->followable->profile_photo_url
                            : $item->followable->team_logo_url,
                        'auth_user' => [
                            'is_followed' => $item->followable->is_followed,
                        ],
                        'bio' => '',
                    ],
                ];
            }),
        ];
    }
}
