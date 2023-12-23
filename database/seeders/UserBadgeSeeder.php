<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Badge;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $badges = Badge::all();

            User::all()->each(function ($user) use ($badges) {
                $user->badges()->attach(
                    $badges->random(rand(0, 3))->pluck('id')->toArray()
                );
            });
        }
    }
}
