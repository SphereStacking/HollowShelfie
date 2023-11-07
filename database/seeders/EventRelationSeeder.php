<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Instance;
use Illuminate\Support\Arr;
use App\Models\EventOrganizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::all()->each(function ($event) {
            $count = rand(1, 4);
            //--------------------------------------------------------
            // タグをランダムに紐づける
            $this->attachRandomModels($event, 'tags', Tag::class, $count);

            //--------------------------------------------------------
            // ユーザーをランダムに「like」として紐づける
            $this->attachRandomModels($event, 'like_users', User::class, $count * 4);

            //--------------------------------------------------------
            // ユーザーをランダムに「good」として紐づける
            $this->attachRandomModels($event, 'good_users', User::class, $count * 4);

            //--------------------------------------------------------
            // カテゴリーをランダムに紐づける
            $this->attachRandomModels($event, 'categories', Category::class, 1);

            //--------------------------------------------------------
            // Performerをランダムに紐づける
            $this->attachRandomModelsPivot($event, 'performers', User::class, $count, function ($event) {
                $date = Carbon::parse($event->start_date);
                $startTime = (clone $date)->addHours(rand(0, 1));
                $endTime = (clone $startTime)->addMinutes(rand(30, 60));
                return [
                    'start_time' => $startTime->format('Y-m-d H:i:s'),
                    'end_time' => $endTime->format('Y-m-d H:i:s')
                ];
            });

            //--------------------------------------------------------
            // ランダムなユーザーを主催者として追加
            $organizers=[];
            for ($i = 0; $i < $count; $i++) {
                $modelClass = rand(0, 1) ? User::class : Team::class;
                $organizerData = $this->createOrganizerData($event->id, $modelClass);
                // $organizerData が null でない場合にのみ、$organizersData に追加する
                if ($organizerData !== null) {
                    $organizers[] = new EventOrganizer($organizerData);;
                }
            }
            // データベースに主催者データを一括挿入
            $event->organizers()->saveMany($organizers);

            //--------------------------------------------------------
            // EventTagをランダムに紐づける
            // インスタンスをランダムに紐づける
            $event->instances()->saveMany(Instance::factory()->count($count)->make());
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

    /**
     * 主催者データを生成するヘルパーメソッド
     *
     * @param int $eventId
     * @param string $modelClass
     * @return array
     */
    private function createOrganizerData($eventId, $modelClass)
    {
        $modelInstance = $modelClass::inRandomOrder()->first();
        if (is_null($modelInstance)) {
            // レコードが見つからない場合はnullを返す
            return null;
        }
        return [
            'event_id' => $eventId,
            'event_organizeble_id' => $modelInstance->id,
            'event_organizeble_type' => get_class($modelInstance)
        ];
    }
}
