<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryWithCountJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return $this->resource->map(function ($tag) {
            return [
                'name' => $tag->name,
                'count' => $tag->events_count,
            ];
        })->toArray();
    }
}
