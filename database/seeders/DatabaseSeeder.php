<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\Followable;
use Illuminate\Database\Seeder;
use Database\Seeders\Initialize;
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
            Initialize\CategorySeeder::class,
            Initialize\InstanceTypeSeeder::class,
            Initialize\PermissionSeeder::class,
            Initialize\RoleSeeder::class,
        ]);

        User::factory(20)->withLink()->withTag()->create();
        Team::factory(10)->withLink()->withTag()->create();
        Followable::factory(10)->create();
        Event::factory(100)
            ->withTag()
            ->withFile()
            ->withEventTimeTable()
            ->withInstances()
            ->withGoodUser()
            ->withBookmarkUser()
            ->withCategory()
            ->create();

        Artisan::call('scout:import', ['model' => 'App\\Models\\Event']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\User']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Team']);
        Artisan::call('scout:import', ['model' => 'App\\Models\\Tag']);
    }
}
