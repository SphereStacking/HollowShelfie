<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('migrate:refresh');
        Artisan::call('scout:flush', ['model' => 'App\\Models\\Event']);
        Artisan::call('scout:flush', ['model' => 'App\\Models\\User']);
        Artisan::call('scout:flush', ['model' => 'App\\Models\\Team']);
        Artisan::call('scout:flush', ['model' => 'App\\Models\\Tag']);

        $this->call([
            AdminUserSeeder::class,
        ]);

        //default値が存在するseeder
        //seed_flagsをみて走るか来まる
        $this->call([
            InitCategorySeeder::class,
            InitTagSeeder::class,
            InitInstanceTypeSeeder::class,
            InitPermissionSeeder::class,
            InitRoleSeeder::class,
        ]);

        User::factory(100)->create();
        Event::factory(1000)->withEventTimeTable()->withInstances()->create();
        $this->call([
            EventRelationSeeder::class,
            TeamRelationSeeder::class,
            UserRelationSeeder::class,
        ]);

        Artisan::call('scout:import', ['model' => 'App\\Models\\Event']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\User']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Team']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Tag']);
    }
}
