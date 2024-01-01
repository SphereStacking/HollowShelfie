<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Link;
use App\Models\Team;
use App\Models\User;
use App\Models\Badge;
use App\Models\Event;
use App\Models\Category;
use App\Models\Instance;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeamRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::all()->each(function ($team) {
            $count = rand(1, 4);
            //--------------------------------------------------------
            $links = Link::factory($count)->make();
            $team->links()->saveMany($links);
            //--------------------------------------------------------
            // ユーザーにランダムに「badge」を紐づける
            $this->attachRandomModels($team, 'badges', Badge::class, $count);
            //--------------------------------------------------------
            // タグをランダムに紐づける
            $this->attachRandomModels($team, 'tags', Tag::class, $count*2);

        });
    }

    /**
     * ランダムなモデルをイベントに紐づける。
     *
     * @param  $event
     * @param  string $relationMethod
     * @param  string $modelClass
     * @param  int    $count
     */
    private function attachRandomModels($model, string $relationMethod, string $modelClass, int $count): void
    {
        $id = $modelClass::inRandomOrder()->limit($count)->pluck('id');
        $model->$relationMethod()->syncWithoutDetaching($id);
    }

    /**
     * ランダムなモデルをイベントに紐づける。際にpivotデータを紐づける。
     *
     * @param Event $event
     * @param string $relationMethod
     * @param string $modelClass
     * @param int $count
     * @param \Closure $func
     */
    private function attachRandomModelsPivot($model, string $relationMethod, string $modelClass, int $count, \Closure $func): void
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
