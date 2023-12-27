<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;

class TagWithCountJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        Log::debug($this->resource);

        return $this->resource->map(function ($tag) {
            return [
                'name' => $tag->name,
                'count' => $tag->events_count,
            ];
        })->toArray();
    }
}
