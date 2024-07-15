<?php

namespace App\Http\Resources;

use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PickupsJsonResource extends JsonResource
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
                switch ($item->pickupable_type) {
                    case User::class:
                        return [
                            'type' => 'user',
                            'id' => $item->pickupable->id,
                            'name' => $item->pickupable->name,
                            'screen_name' => $item->pickupable->screenName->screen_name,
                            'profile_url' => $item->pickupable->profile_url,
                            'image_url' => $item->pickupable->profile_photo_url,
                        ];
                    case Team::class:
                        return [
                            'type' => 'team',
                            'id' => $item->pickupable->id,
                            'name' => $item->pickupable->name,
                            'screen_name' => $item->pickupable->screenName->screen_name,
                            'profile_url' => $item->pickupable->profile_url,
                            'image_url' => $item->pickupable->team_logo_url,
                        ];
                    case Event::class:
                        return [
                            'type' => 'event',
                            'id' => $item->pickupable->id,
                            'title' => $item->pickupable->title,
                        ];
                }
            }),
        ];
    }
}
