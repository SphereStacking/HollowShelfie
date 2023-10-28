<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\EventTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $isTruncate = false;

        if ($isTruncate) {
            User::where('id', '<>', 1)->delete();
            DB::table('events')->truncate();
            DB::table('tags')->truncate();
            DB::table('event_tag')->truncate();
            DB::table('event_user_like')->truncate();
            DB::table('event_user_good')->truncate();
            DB::table('categories')->truncate();
            DB::table('event_category')->truncate();
            DB::table('seed_flags')->truncate();
        }
        if (!$isTruncate) {
            User::factory(10)->create();
        }
        //default値が存在するseeder
        //seed_flagsをみて走るか来まる
        $this->call([
            InitCategorySeeder::class,
            InitTagSeeder::class
        ]);

        //
        Event::factory(30)->create();
        $this->call([
            EventRelationSeeder::class
        ]);
    }
}
