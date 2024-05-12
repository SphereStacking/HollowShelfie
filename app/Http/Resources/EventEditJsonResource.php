<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventEditJsonResource extends JsonResource
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
            'created_at' => $this->resource->created_at,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
            'category_names' => $this->resource->category_names,
            'tags' => $this->resource->tags,
            'status' => $this->resource->status,
            'create_user' => $this->resource->event_create_user,
            'event_timeline_status' => $this->resource->event_timeline_status,
            'start_date' => $this->resource->start_date,
            'end_date' => $this->resource->end_date,
            'good_count' => $this->resource->good_count,
            'short_good_count' => $this->resource->short_good_count,
            'files' => $this->resource->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'public_url' => $file->public_url,
                ];
            }),
            'organizers' => $this->resource->organizers->map(function ($organizeble) {
                return [
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'name' => $organizeble->event_organizeble->name,
                    'screen_name' => $organizeble->event_organizeble->screen_name,
                    'image_url' => $organizeble->event_organizeble_type === User::class
                        ? $organizeble->event_organizeble->profile_photo_url
                        : $organizeble->event_organizeble->team_logo_url,
                ];
            }),
            'time_table' => $this->resource->event_time_tables->map(function ($time_table) {
                return [
                    'id' => $time_table->id,
                    'description' => $time_table->description,
                    'duration' => $time_table->duration,
                    'start_date' => $time_table->start_date,
                    'end_date' => $time_table->end_date,
                    'performers' => $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable_id,
                            'type' => $performer->performable_type,
                            'name' => $performer->performable->name,
                            'screen_name' => $performer->performable->screen_name,
                            'image_url' => $performer->performable_type === User::class
                                ? $performer->performable->profile_photo_url
                                : $performer->performable->team_logo_url,
                        ];
                    }),
                ];
            }),
            'instances' => $this->resource->instances->map(function ($instance) {
                return [
                    'instance_type_id' => $instance->instance_type_id,
                    'instance_type_name' => $instance->instance_type_name,
                    'access_url' => $instance->access_url,
                    'display_name' => $instance->display_name,
                ];
            }),
        ];
    }
}
