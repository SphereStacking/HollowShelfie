<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPublicProfileJsonResource extends JsonResource
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
            'dataile' => [
                'name' => $this->name,
                'photo_url' => $this->profile_photo_url,
                'join_at' => $this->created_at,
                'location' => 'TODO',
                'languages' => ['jp', 'kr'],
                'links' => $this->links->map(function ($link) {
                    return [
                        'label' => $link->label,
                        'link' => $link->link,
                    ];
                }),
                'followers_count' => $this->followersCount(),
                'bio' => 'TODO',
                'badges' => ['official'],
            ],
            'auth_user' => [
                'is_followed' => false,
            ],
            'events' => [
                'organized' => $this->events_organized,
                'performered' => [],
            ],
            'logs' => [
                [
                    'description' => '出演 DJ [Concert in Tokyo]',
                    'time' => '1 days ago'
                ],
                [
                    'description' => '出演 VL [Concert in Tokyo]',
                    'time' => '2 days ago'
                ],
                [
                    'description' => '主催 LJ [Charity Event]',
                    'time' => '3 days ago'
                ],
                [
                    'description' => '運営 雑用 [Art Exhibition]',
                    'time' => '20 days ago'
                ],
            ],

        ];
    }
}
