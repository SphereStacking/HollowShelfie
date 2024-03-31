<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FollowablePaginatedResource extends JsonResource
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
                // followするのはuserのみのため配列にいれる。
                return [
                    'name' => $item->user->name,
                    'screen_name' => $item->user->screen_name,
                    'profile_url' => $item->user->profile_url,
                    'image_url' => $item->user->profile_photo_url,
                    'auth_user' => [
                        'is_followed' => $item->user->is_followed,
                    ],
                    'bio' => 'TODO', // TODO:
                ];
            }),
        ];
    }
}
