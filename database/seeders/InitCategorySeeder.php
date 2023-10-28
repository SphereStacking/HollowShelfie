<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class InitCategorySeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        $InitCategories = [
            '音楽',
            'アバター集会',
            '集会',
            'アート',
            'ゲーム',
            'スポーツ',
            'cafe',
            'Bar',

        ];
        foreach ($InitCategories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
