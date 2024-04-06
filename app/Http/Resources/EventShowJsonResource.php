<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventShowJsonResource extends JsonResource
{
    /**
     * リソースを配列に変換します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'title' => $this->title,
            'description' => $this->description,
            'category_names' => $this->category_names,
            'tags' => $this->tags,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'create_user' => $this->event_create_user,
            'event_timeline_status' => $this->event_timeline_status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'formatted_start_date' => $this->getFormattedStartDateAttribute(),
            'formatted_end_date' => $this->getFormattedEndDateAttribute(),
            'good_count' => $this->good_count,
            'short_good_count' => $this->short_good_count,
            'files' => $this->files->map(function ($file) {
                return [
                    'id' => $file->id,
                    'public_url' => $file->public_url,
                ];
            }),
            'organizers' => $this->organizers->map(function ($organizeble) {
                return [
                    'profile_url' => $organizeble->event_organizeble->profile_url,
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'image_url' => $organizeble->event_organizeble_type === User::class
                        ? $organizeble->event_organizeble->profile_photo_url
                        : $organizeble->event_organizeble->team_logo_url,
                    'name' => $organizeble->event_organizeble->name,
                    'links' => $organizeble->event_organizeble->links->map(function ($link) {
                        return [
                            'label' => $link->label,
                            'link' => $link->link,
                        ];
                    }),
                ];
            }),
            'performers' => $this->event_time_tables->flatMap(function ($time_table) {
                return $time_table->performers;
            })->unique(function ($performer) {
                return $performer->performable_type.$performer->performable_id;
            })->map(function ($performer) {
                return [
                    'id' => $performer->performable_id,
                    'profile_url' => $performer->performable->profile_url,
                    'name' => $performer->performable->name,
                    'links' => $performer->performable->links->map(function ($link) {
                        return [
                            'label' => $link->label,
                            'link' => $link->link,
                        ];
                    }),
                    'type' => $performer->performable_type,
                    'image_url' => $performer->performable_type === User::class
                        ? $performer->performable->profile_photo_url
                        : $performer->performable->team_logo_url,
                ];
            }
            )->values(),
            'time_table' => $this->event_time_tables->map(function ($time_table) {
                return [
                    'id' => $time_table->id,
                    'description' => $time_table->description,
                    'start_time' => $time_table->start_time,
                    'end_time' => $time_table->end_time,
                    'performance_time' => $time_table->performance_time,
                    'performers' => $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable->id,
                            'profile_url' => $performer->performable->profile_url,
                            'name' => $performer->performable->name,
                            'links' => $performer->performable->links->map(function ($link) {
                                return [
                                    'label' => $link->label,
                                    'link' => $link->link,
                                ];
                            }),
                            'type' => $performer->performable->performable_type,
                            'image_url' => $performer->performable_type === User::class
                                ? $performer->performable->profile_photo_url
                                : $performer->performable->team_logo_url,
                        ];
                    }),
                ];
            }),
            'instances' => $this->instances->map(function ($instance) {
                return [
                    'instance_type' => $instance->instance_type_name,
                    'access_url' => $instance->access_url,
                    'display_name' => $instance->display_name,
                ];
            }),
            'auth_user' => [
                'is_good' => $this->is_good ?? false,
                'is_bookmark' => $this->is_bookmark ?? false,
            ],

        ];
    }
}
