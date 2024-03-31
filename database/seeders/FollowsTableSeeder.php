<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FollowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $teams = Team::all();

        $users->each(function ($user) use ($users, $teams) {
            // ユーザーがフォローできる最大数を取得
            $maxUsersToFollow = $users->count() - 1; // 自分自身を除く
            $maxTeamsToFollow = $teams->count();

            // ランダムな数のユーザーをフォロー（自分自身を除く）
            $usersToFollow = $users->except($user->id)->random(min(rand(1, 3), $maxUsersToFollow))->pluck('id');
            foreach ($usersToFollow as $followId) {
                DB::table('follows')->updateOrInsert([
                    'user_id' => $user->id,
                    'followable_id' => $followId,
                    'followable_type' => 'App\Models\User',
                ]);
            }

            // ランダムな数のチームをフォロー
            $teamsToFollow = $teams->random(min(rand(1, 3), $maxTeamsToFollow))->pluck('id');
            foreach ($teamsToFollow as $followId) {
                DB::table('follows')->updateOrInsert([
                    'user_id' => $user->id,
                    'followable_id' => $followId,
                    'followable_type' => 'App\Models\Team',
                ]);
            }
        });
    }
}
