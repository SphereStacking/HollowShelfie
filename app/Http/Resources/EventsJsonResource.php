<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventsJsonResource extends JsonResource
{
    /**
     * リソースを配列に変換します。
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->map(function ($item) {
            return [
                'id' => $item->id,
                'created_at' => $item->created_at,
                'title' => $item->title,
                'description' => $item->description,
                'category_name' => $item->category_name,
                'tags' =>  $item->tags,
                'status' => $item->status,
                'status_label' => $item->status_label,
                'status_label' => $item->status_label,
                'good_count' => $item->good_count,
                'short_good_count' => $item->short_good_count,
                'event_timeline_status' => $item->event_timeline_status,
                'organizers' => $item->organizers->map(function ($organizeble) {
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
                'performers'=> $item->event_time_tables->flatMap(function ($time_table) {
                    return $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable->id,
                            'profile_url' => $performer->performable_type === User::class
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
                    });
                }),
                'instances' => $item->instances->map(function ($instance) {
                    return [
                        'instance_type' => $instance->instance_type_name,
                        'location' => $instance->location,
                    ];
                }),
                'auth_user' => [
                    'is_good' => $item->is_good ?? false,
                    'is_bookmark' => $item->is_bookmark ?? false,
                ],
            ];
        });
    }
}
