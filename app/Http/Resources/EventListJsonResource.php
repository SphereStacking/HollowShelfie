<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Enums\EventStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class EventListJsonResource extends JsonResource
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
            // 'debug' => $this->resource,
            'pagination' => [
                'current_page' => $this->resource->currentPage(),
                'first_page_url' => $this->resource->url(1),
                'from' => $this->resource->firstItem(),
                'last_page' => $this->resource->lastPage(),
                'links' => $this->resource->linkCollection(),
                'next_page_url' => $this->resource->nextPageUrl(),
                'path' => $this->resource->path(),
                'per_page' => $this->resource->perPage(),
                'prev_page_url' => $this->resource->previousPageUrl(),
                'to' => $this->resource->lastItem(),
                'total' => $this->resource->total(),
            ],
            'data' => $this->resource->map(function ($item) {
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
            })
        ];
    }
}
