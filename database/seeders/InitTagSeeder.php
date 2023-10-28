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
            '☁寝落もちもち☁',
        ];
        foreach ($InitCategories as $category) {
            Tag::create(['name' => $category]);
        }
    }
}
