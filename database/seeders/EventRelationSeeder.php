<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\EventOrganizer;
use App\Models\EventTimeTable;
use App\Models\Tag;
use App\Models\Team;
use App\Models\TimeTablePerformers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class EventRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = Storage::disk('public')->files('dummy');
        Event::all()->each(function ($event) use ($files) {
            $count = rand(1, 4);

            // タグをランダムに紐づける
            $this->attachRandomModels($event, 'tags', Tag::class, $count);
            //--------------------------------------------------------
            // ユーザーをランダムに「bookmark」として紐づける
            $this->attachRandomModels($event, 'bookmark_users', User::class, $count * 4);

            //--------------------------------------------------------
            // ユーザーをランダムに「good」として紐づける
            $this->attachRandomModels($event, 'good_users', User::class, $count * 4);

            //--------------------------------------------------------
            // カテゴリーをランダムに紐づける
            $this->attachRandomModels($event, 'categories', Category::class, 1);

            //--------------------------------------------------------
            // Performerをランダムに紐づける
            // $this->attachRandomModelsPivot($event, 'performers', User::class, $count, function ($event) {
            //     $date = Carbon::parse($event->start_date);
            //     $startTime = (clone $date)->addHours(rand(0, 1));
            //     $endTime = (clone $startTime)->addMinutes(rand(30, 60));
            //     return [
            //         'start_time' => $startTime->format('Y-m-d H:i:s'),
            //         'end_time' => $endTime->format('Y-m-d H:i:s')
            //     ];
            // });

            // ランダムでrand(2 ,4)で複数のタイムテーブルを作成
            for ($i = 0; $i < rand(2, 4); $i++) {
                $eventTimeTable = EventTimeTable::factory()->create([
                    'event_id' => $event->id,
                ]);
                // TimeTablePerformersはrand(1 ,2)の範囲で作成
                TimeTablePerformers::factory()->count(rand(1, 2))->create([
                    'event_time_table_id' => $eventTimeTable->id,
                ]);
            }

            for ($i = 0; $i < rand(1, 4); $i++) {
                $randomFile = Arr::random($files); // ランダムに一つ選択
                $fileName = basename($randomFile); // ファイル名のみを取得
                $event->files()->create([
                    'path' => 'dummy',
                    'name' => $fileName,
                    'original_name' => $fileName,
                    'type' => 'image/jpeg',
                ]);
            }

            //--------------------------------------------------------
            // ランダムなユーザーを主催者として追加
            $organizers = [];
            for ($i = 0; $i < $count; $i++) {
                $modelClass = rand(0, 1) ? User::class : Team::class;
                $organizerData = $this->createOrganizerData($event->id, $modelClass);
                // $organizerData が null でない場合にのみ、$organizersData に追加する
                if ($organizerData !== null) {
                    $organizers[] = new EventOrganizer($organizerData);
                }
            }
            // データベースに主催者データを一括挿入
            $event->organizers()->saveMany($organizers);

        });
    }

    /**
     * ランダムなモデルをイベントに紐づける。
     *
     * @param    $event
     */
    private function attachRandomModels($model, string $relationMethod, string $modelClass, int $count): void
    {
        $id = $modelClass::inRandomOrder()->limit($count)->pluck('id');
        $model->$relationMethod()->syncWithoutDetaching($id);
    }

    /**
     * ランダムなモデルをイベントに紐づける。際にpivotデータを紐づける。
     *
     * @param  Event  $event
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
     * @param  int  $eventId
     * @param  string  $modelClass
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
            'event_organizeble_type' => get_class($modelInstance),
        ];
    }
}
