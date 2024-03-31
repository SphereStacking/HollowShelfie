<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class MentionsuggestionJsonResource extends JsonResource
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
            'debug' => $this->resource,
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
                // UserやTeamをfollowしているためfollowableに入れる。
                return [
                    'identifiable_id' => $item->identifiable_id,
                    'identifiable_type' => $item->identifiable_type,
                    'alias_name' => $item->alias_name,
                    'name' => $item->aliasable->name,
                    'image_url' => $item->identifiable_type === User::class
                        ? $item->aliasable->profile_photo_url
                        : $item->aliasable->team_logo_url,
                ];
            }),
        ];
    }
}
