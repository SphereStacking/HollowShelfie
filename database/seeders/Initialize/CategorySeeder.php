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
            '集会',
            'Tech',
            '展示会',
            'コンサート',
            'Dance ',
            'Other',
        ];

        foreach ($InitCategories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
