<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class EventEditJsonResource extends JsonResource
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
            'images' => $this->files->map(function ($file) {
                return [
                    'url' => $file->url,
                ];
            }),
            'id' => $this->id,
            'created_at' => $this->created_at,
            'title' => $this->title,
            'description' => $this->description,
            'category_names' => $this->category_names,
            'tags' =>  $this->tags,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'create_user' => $this->event_create_user,
            'event_timeline_status' => $this->event_timeline_status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'period' => $this->period,
            'formatted_start_date' => $this->formatted_start_date,
            'formatted_end_date' => $this->formatted_end_date,
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
                    'id' => $organizeble->event_organizeble_id,
                    'type' => $organizeble->event_organizeble_type,
                    'name' => $organizeble->event_organizeble->name,
                ];
            }),
            'performers'=> $this->event_time_tables->flatMap(function ($time_table) {
                return $time_table->performers->map(function ($performer) {
                    return [
                        'id' => $performer->performable->id,
                        'name' => $performer->performable->name,
                        'type' => $performer->performable->performable_type,
                    ];
                });
            }),
            'time_table' => $this->event_time_tables->map(function ($time_table) {
                return [
                    'id' => $time_table->id,
                    'description' => $time_table->description,
                    'times' => [
                        $time_table->start_time,
                        $time_table->end_time,
                    ],
                    'performers' => $time_table->performers->map(function ($performer) {
                        return [
                            'id' => $performer->performable_id,
                            'type' => $performer->performable_type,
                            'name' => $performer->performable->name,
                        ];
                    }),
                ];
            }),
            'instances' => $this->instances->map(function ($instance) {
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
