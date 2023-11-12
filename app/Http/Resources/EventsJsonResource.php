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
                'status_label' => $item->status_label,                'status_label' => $item->status_label,
                'formatted_date_time' => $item->formatted_date_time,
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
                'instances' => $item->instances->map(function ($instance) {
                    return [
                        'instance_type' => $instance->instance_type_name,
                        'location' => $instance->link,
                    ];
                }),
                'auth_user' => [
                    'is_good' => $item->is_good,
                    'is_bookmark' => $item->is_bookmark,
                ],
            ];
        });
    }
}
