<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EventRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::all()->each(function ($event) {
            $count = rand(1, 4);
            //ランダムにタグを紐づける。
            $tags = Tag::inRandomOrder()->limit($count)->get();
            $event->tags()->syncWithoutDetaching($tags);

            //ランダムにイベントを紐づける。
            $user = User::inRandomOrder()->limit($count * 4)->get();
            $event->like_users()->syncWithoutDetaching($user);


            //ランダムにイベントを紐づける。
            $user = User::inRandomOrder()->limit($count * 4)->get();
            $event->good_users()->syncWithoutDetaching($user);
        });
    }
}
