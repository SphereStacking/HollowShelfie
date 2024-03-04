<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tag;
use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\TeamRelationSeeder;
use Database\Seeders\UserRelationSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('migrate:refresh');

        $this->call([
            AdminUserSeeder::class,
        ]);

        //default値が存在するseeder
        //seed_flagsをみて走るか来まる
        $this->call([
            InitCategorySeeder::class,
            InitTagSeeder::class,
            InitInstanceTypeSeeder::class,
            InitBadgeSeeder::class,
        ]);

        User::factory(100)->create();
        Event::factory(1000)->create();
        $this->call([
            EventRelationSeeder::class,
            TeamRelationSeeder::class,
            UserRelationSeeder::class,
        ]);

        Artisan::call('scout:import', ['model' => 'App\\Models\\Event']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\User']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Team']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Tag']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\CustomIdentifiable']);
    }
}
