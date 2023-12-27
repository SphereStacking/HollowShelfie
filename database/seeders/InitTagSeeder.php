<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitTagSeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        $InitCategories = [
            'DJ',
            'VJ',
            'House',
            'Trance',
            'Drum and Bass',
            'Techno',
            'Deep House',
            'Progressive House',
            'TRPG',
            'クトゥルフ',
            '雑談',
            'V睡',
            '舞台',
            '演劇',
            'パーティクル',
            'マダミス',
            '異文化交流',
            'visitor案内',
        ];
        foreach ($InitCategories as $category) {
            Tag::create(['name' => $category]);
        }
    }
}
