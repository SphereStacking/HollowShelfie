<?php
namespace App\Http\Resources;

use App\Models\User;
use App\Enums\EventStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowPaginatedResource extends JsonResource
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
                    'id' => $item->id,
                    'type' => $item->followable_type,
                    'followable'=>[
                        'name' => $item->followable->name,
                        'screen_name' => $item->followable->screen_name,
                        'profile_url' => $item->followable->profile_url,
                        'image_url' => $item->followable->profile_photo_url,
                        'auth_user' => [
                            'is_followed' => $item->followable->is_followed,
                        ],
                        'bio' => 'TODO', // TODO:
                    ],
                ];
            })
        ];
    }
}
