<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Tag;
use App\Models\User;
use Closure;
use Illuminate\Database\Seeder;

class UserRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            $count = rand(1, 4);

            //--------------------------------------------------------
            $links = Link::factory($count)->make();
            $user->links()->saveMany($links);

            //--------------------------------------------------------
            // タグをランダムに紐づける
            $this->attachRandomModels($user, 'tags', Tag::class, $count * 2);
        });
    }

    /**
     * ランダムなモデルをイベントに紐づける。
     */
    private function attachRandomModels($model, string $relationMethod, string $modelClass, int $count): void
    {
        $id = $modelClass::inRandomOrder()->limit($count)->pluck('id');
        $model->$relationMethod()->syncWithoutDetaching($id);
    }

    /**
     * ランダムなモデルをイベントに紐づける。際にpivotデータを紐づける。
     */
    private function attachRandomModelsPivot($model, string $relationMethod, string $modelClass, int $count, Closure $func): void
    {
        $ids = $modelClass::inRandomOrder()->limit($count)->pluck('id');
        $attachData = call_user_func($func, $model);
        foreach ($ids as $id) {
            $attachData = call_user_func($func, $model);
            // pivotデータを各モデルに対して適用
            $model->$relationMethod()->syncWithoutDetaching([$id => $attachData]);
        }
    }
}
