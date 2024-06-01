<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;

class EventUpdatedJsonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'alias' => $this->resource->alias,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'status' => $this->resource->status,
            'category_names' => $this->resource->categories->pluck('name')->toArray(),
            'tags' => $this->resource->tags->pluck('name')->toArray(),
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'files' => $this->resource->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'public_url' => $file->public_url,
                ];
            }),
            'organizers' => $this->resource->organizers->map(function ($organizeble) {
                return [
                    'profile_url' => $organizeble->event_organizeble->profile_url,
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'image_url' => $organizeble->event_organizeble_type === User::class
                        ? $organizeble->event_organizeble->profile_photo_url
                        : $organizeble->event_organizeble->team_logo_url,
                    'name' => $organizeble->event_organizeble->name,
                ];
            }),
            'performers' => $this->resource->event_time_tables
                ->flatMap(function ($time_table) {
                    return $time_table->performers;
                })->unique(function ($performer) {
                    return $performer->performable_type.$performer->performable_id;
                })->map(function ($performer) {
                    return [
                        'id' => $performer->performable_id,
                        'profile_url' => $performer->performable->profile_url,
                        'name' => $performer->performable->name,
                        'type' => $performer->performable_type,
                        'image_url' => $performer->performable_type === User::class
                            ? $performer->performable->profile_photo_url
                            : $performer->performable->team_logo_url,
                    ];
                }
            )->values(),
            'instances' => $this->resource->instances->map(function ($instance) {
                return [
                    'instance_type' => $instance->instance_type_name,
                    'access_url' => $instance->access_url,
                    'display_name' => $instance->display_name,
                ];
            }),
        ];
    }
}
