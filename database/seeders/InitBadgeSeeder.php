<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class InitBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            // ['name' => '',  'description' => '',   'icon_class' => ''],
            //運営
            ['name' => 'god',             'description' => '',   'icon_class' => 'mdi:shield-crown'],
            ['name' => 'developer',       'description' => '',   'icon_class' => 'mdi:shield-bug'],
            ['name' => 'admin',           'description' => '',   'icon_class' => 'mdi:shield-cross'],
            ['name' => 'customer',        'description' => '',   'icon_class' => 'mdi:shield-cross'],
            ['name' => 'authenticated',   'description' => '',   'icon_class' => 'mdi:check-decagram'],
            ['name' => 'test1',           'description' => '',   'icon_class' => 'mdi:shield-star'],
            ['name' => 'test2',           'description' => '',   'icon_class' => 'mdi:shield-sun'],
            ['name' => 'test3',           'description' => '',   'icon_class' => 'mmdi:shield-sword'],
            ['name' => 'test3',           'description' => '',   'icon_class' => 'mdi:shield-half-full'],
            ['name' => 'test4',           'description' => '',   'icon_class' => 'mdi:shield-home'],
            ['name' => 'test5',           'description' => '',   'icon_class' => 'mdi:shield-key'],

            //一般ユーザー
            ['name' => 'dolphin',        'description' => '',   'icon_class' => 'mdi:dolphin'],
            ['name' => 'dog',            'description' => '',   'icon_class' => 'mdi:dog'],
            ['name' => 'donkey',         'description' => '',   'icon_class' => 'mdi:donkey'],
            ['name' => 'poop',           'description' => '',   'icon_class' => 'mdi:emoticon-poop'],
            ['name' => 'owl',            'description' => '',   'icon_class' => 'mdi:owl'],
            ['name' => 'penguin',        'description' => '',   'icon_class' => 'mdi:penguin'],
            ['name' => 'pig',            'description' => '',   'icon_class' => 'mdi:pig'],
            ['name' => 'robot',          'description' => '',   'icon_class' => 'mdi:robot'],
            ['name' => 'rodent',         'description' => '',   'icon_class' => 'mdi:rodent'],
            ['name' => 'snail',          'description' => '',   'icon_class' => 'mdi:snail'],
            ['name' => 'snake',          'description' => '',   'icon_class' => 'mdi:snake'],
            ['name' => 'snapchat',       'description' => '',   'icon_class' => 'mdi:snapchat'],
            ['name' => 'snowman',        'description' => '',   'icon_class' => 'mdi:snowman'],
            ['name' => 'spider',         'description' => '',   'icon_class' => 'mdi:spider'],
            ['name' => 'sticker-emoji',  'description' => '',   'icon_class' => 'mdi:sticker-emoji'],
            ['name' => 'unicorn',        'description' => '',   'icon_class' => 'mdi:unicorn'],

        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
