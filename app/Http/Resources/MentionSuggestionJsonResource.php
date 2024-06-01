<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentionSuggestionJsonResource extends JsonResource
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
                return [
                    'id' => $item->screenNameable->id,
                    'screen_name' => $item->screen_name,
                    'name' => $item->name,
                    'image_url' => $item->screen_nameable_type === User::class
                        ? $item->screenNameable->profile_photo_url
                        : $item->screenNameable->team_logo_url,
                    'type' => $item->screen_nameable_type
                ];
            }),
        ];
    }
}
