<?php

namespace Database\Seeders\Initialize;

use App\Models\Category;
use Illuminate\Database\Seeder;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //大体日本語4文字が限界
        //フロント側の
        $InitCategories = [
            'Music',
            'Club',
            'Game',
            'Bar',
            'Tech',
            'Dance ',
            'コンサート',
            '集会',
            '展示会',
            '企業',
            'Other',
        ];

        foreach ($InitCategories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
