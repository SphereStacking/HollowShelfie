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
                'tags' => $item->tags,
                'status' => $item->status,
                'status_label' => $item->status_label,
                'good_count' => $item->good_count,
                'short_good_count' => $item->short_good_count,
                'event_timeline_status' => $item->event_timeline_status,
                'files' => $item->files->map(function ($file) {
                    return [
                        'id' => $file->id,
                        'public_url' => $file->public_url,
                    ];
                }),
                'organizers' => $item->organizers->map(function ($organizeble) {
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
                'performers' => $item->event_time_tables->flatMap(function ($time_table) {
                        return $time_table->performers;
                    })->unique(function ($performer) {
                        return $performer->performable_type . $performer->performable_id;
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
                'instances' => $item->instances->map(function ($instance) {
                    return [
                        'instance_type' => $instance->instance_type_name,
                        'access_url' => $instance->access_url,
                        'display_name' => $instance->display_name,
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
