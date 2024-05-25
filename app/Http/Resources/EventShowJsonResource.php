<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventShowJsonResource extends JsonResource
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
            'category_names' => $this->resource->categories->pluck('name')->toArray(),
            'tags' => $this->resource->tags->pluck('name')->toArray(),
            'status' => $this->resource->status,
            'create_user' => $this->resource->event_create_user,
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
                    'profile_url' => $organizeble->event_organizeble->profile_url,
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'image_url' => $organizeble->event_organizeble_type === User::class
                        ? $organizeble->event_organizeble->profile_photo_url
                        : $organizeble->event_organizeble->team_logo_url,
                    'name' => $organizeble->event_organizeble->name,
                    // 'links' => $organizeble->event_organizeble->links->map(function ($link) {
                    //     return [
                    //         'label' => $link->label,
                    //         'link' => $link->link,
                    //     ];
                    // }),
                ];
            }),
            'performers' => $this->resource->event_time_tables->flatMap(function ($time_table) {
                return $time_table->performers;
            })->unique(function ($performer) {
                return $performer->performable_type.$performer->performable_id;
            })->map(function ($performer) {
                return [
                    'id' => $performer->performable_id,
                    'profile_url' => $performer->performable->profile_url,
                    'name' => $performer->performable->name,
                    // 'links' => $performer->performable->links->map(function ($link) {
                    //     return [
                    //         'label' => $link->label,
                    //         'link' => $link->link,
                    //     ];
                    // }),
                    'type' => $performer->performable_type,
                    'image_url' => $performer->performable_type === User::class
                        ? $performer->performable->profile_photo_url
                        : $performer->performable->team_logo_url,
                ];
            }
            )->values(),
            'time_table' => $this->resource->event_time_tables->map(function ($time_table) {
                return [
                    'id' => $time_table->id,
                    'description' => $time_table->description,
                    'start_date' => $time_table->start_date,
                    'end_date' => $time_table->end_date,
                    'performers' => $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable->id,
                            'profile_url' => $performer->performable->profile_url,
                            'name' => $performer->performable->name,
                            // 'links' => $performer->performable->links->map(function ($link) {
                            //     return [
                            //         'label' => $link->label,
                            //         'link' => $link->link,
                            //     ];
                            // }),
                            'type' => $performer->performable->performable_type,
                            'image_url' => $performer->performable_type === User::class
                                ? $performer->performable->profile_photo_url
                                : $performer->performable->team_logo_url,
                        ];
                    }),
                ];
            }),
            'instances' => $this->resource->instances->map(function ($instance) {
                return [
                    'instance_type' => $instance->instance_type_name,
                    'access_url' => $instance->access_url,
                    'display_name' => $instance->display_name,
                ];
            }),
            'auth_user' => [
                'is_good' => $this->resource->is_good ?? false,
                'is_bookmark' => $this->resource->is_bookmark ?? false,
            ],

        ];
    }
}
