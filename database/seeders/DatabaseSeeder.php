<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use App\Models\EventTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\TeamRelationSeeder;
use Database\Seeders\UserRelationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $isTruncate = true;
        $this->call([
            // AdminUserSeeder::class,
        ]);
        if ($isTruncate) {
            DB::table('seed_flags')->truncate();

            User::where('id', '<>', 1)->delete();

            DB::table('categories')->truncate();
            DB::table('category_event')->truncate();
            DB::table('event_organizers')->truncate();
            DB::table('event_tag')->truncate();
            DB::table('event_user_good')->truncate();
            DB::table('event_user_like')->truncate();
            DB::table('event_time_table')->truncate();
            DB::table('events')->truncate();
            DB::table('instance_types')->truncate();
            DB::table('instances')->truncate();
            DB::table('links')->truncate();

            DB::table('tags')->truncate();
        }
        if (User::count() < 10) {
            User::factory(10)->create();
        }

        //default値が存在するseeder
        //seed_flagsをみて走るか来まる
        $this->call([
            InitCategorySeeder::class,
            InitTagSeeder::class,
            InitInstanceTypeSeeder::class,
        ]);

        //
        Event::factory(100)->create();
        $this->call([
            EventRelationSeeder::class,
            TeamRelationSeeder::class,
            UserRelationSeeder::class
        ]);
    }
}
