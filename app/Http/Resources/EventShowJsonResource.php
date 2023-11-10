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
            'category_name' => $this->category_name,
            'tags' =>  $this->tags,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'create_user' => $this->event_create_user,
            'formatted_date_time' => $this->formatted_date_time,
            'organizers' => $this->organizers->map(function ($organizeble) {
                return [
                    'profile_url' =>  $organizeble->event_organizeble_type === User::class
                        ? route('user.profile.show', $organizeble->event_organizeble_id)
                        : route('team.profile.show', $organizeble->event_organizeble_id),
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'imag_url' =>  $organizeble->event_organizeble_type === User::class
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
            'time_table' => $this->event_time_tables->map(function ($time_table) {
                return [
                    'id' => $time_table->id,
                    'description' => $time_table->description,
                    'start_date' => $time_table->start_date,
                    'end_date' => $time_table->end_date,
                    'performance_time' => $time_table->performance_time,
                    'performers' => $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable->id,
                            'profile_url' => $performer->performable->performable_type === User::class
                                ? route('user.profile.show', $performer->performable->id)
                                : route('team.profile.show', $performer->performable->id),
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
                                : $performer->performable->team_logo_url
                        ];
                    }),
                ];
            }),
            'instances' => $this->instances->map(function ($instance) {
                return [
                    'instance_type' => $instance->instance_type_name,
                    'location' => $instance->link,
                ];
            }),
            'auth_user' => [
                'is_good' => $this->is_good,
                'is_like' => $this->is_like,
            ],

        ];
    }
}
