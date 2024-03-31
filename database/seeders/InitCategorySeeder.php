<?php

namespace Database\Seeders;

use App\Models\Category;

class InitCategorySeeder extends AbstractOnceSeeder
{
    /**
     * Run the database seeds.
     */
    public function runOnce(): void
    {
        //大体日本語4文字が限界
        //フロント側の
        $InitCategories = [
            '音楽',
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
