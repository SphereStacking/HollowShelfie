<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamPublicProfileJsonResource extends JsonResource
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
                'id' => $this->id,
                'screen_name' => $this->screen_name,
                'name' => $this->name,
                'photo_url' => $this->team_logo_url,
                'profile_url' => route('user.profile.show', $this->id),
                'location' => 'TODO',
                'links' => $this->links->map(function ($link) {
                    return [
                        'label' => $link->label,
                        'link' => $link->link,
                    ];
                }),
                'followers_count' => $this->followers_count,
                'content' => 'hogegegege',
                'tags' => $this->tags->map(function ($tag) {
                    return [
                        'name' => $tag->name,
                    ];
                }),
                'badges' => $this->badges->map(function ($badge) {
                    return [
                        'name' => $badge->name,
                        'icon_class' => $badge->icon_class,
                    ];
                }),
            ],
            'auth_user' => [
                'is_followed' => $this->is_followed,
            ],
        ];
    }
}
