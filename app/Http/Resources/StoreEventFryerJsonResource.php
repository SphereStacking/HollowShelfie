<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreEventFryerJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return collect($this->resource)->map(function ($file) {
            return [
                'id' => $file->id,
                'public_url' => $file->public_url,
            ];
        })->toArray();
    }
}
