<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\File;
use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use App\Models\Instance;
use App\Models\EventOrganizer;
use App\Models\EventTimeTable;
use App\Models\TimeTablePerformers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $dateTime = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $formattedDateTime = Carbon::instance($dateTime)->format('Ymd\THis\Z');

        // 開始時間からランダムに2~6時間後を終了時間とする
        $endDateTime = Carbon::instance($dateTime)->addHours(rand(2, 6))->format('Ymd\THis\Z');
        return [
            'created_user_id' => User::inRandomOrder()->first()->id,
            'is_forced_hidden' => $this->faker->boolean(20),
            'title' => $this->faker->text(20),
            'start_date' => $formattedDateTime,
            'end_date' => $endDateTime,
            'description' => $this->faker->paragraphs(5, true),
            'published_at' => function () {
                $random = rand(1, 4);
                if ($random === 1) {
                    return null;
                } elseif ($random === 2) {
                    return $this->faker->dateTimeBetween('+1 day', '+1 month');
                } else {
                    return $this->faker->dateTimeBetween('-1 month', 'now');
                }
            },
            'alias' => $this->faker->unique()->slug(2),
        ];
    }

    public function withOrganizer(callable $callback = null)
    {
        // データベースに主催者データを一括挿入
        return $this->afterCreating(function (Event $event) {
            $organizers = [];
            $count = rand(1, 4);
            for ($i = 0; $i < $count; $i++) {
                $modelClass = rand(0, 1) ? User::class : Team::class;
                $organizers[] = EventOrganizer::factory()->create([
                    'event_id' => $event->id,
                    'event_organizeble_type' => $modelClass,
                    'event_organizeble_id' => $modelClass::inRandomOrder()->first()->id
                ]);
            }
            $event->organizers()->saveMany($organizers);

        });
    }

    public function withBookmarkUser(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {
            $id = User::inRandomOrder()->limit(rand(1, 100))->pluck('id');
            $event->bookmark_users()->syncWithoutDetaching($id);
        });
    }

    public function withTag(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) use ($callback) {
            // 既存のタグをランダムに選択してアタッチ
            $tagIds = Tag::inRandomOrder()->limit(rand(1, 4))->pluck('id');
            $event->tags()->syncWithoutDetaching($tagIds);
        });
    }


    public function withGoodUser(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {
            $id = User::inRandomOrder()->limit(rand(1, 100))->pluck('id');
            $event->good_users()->syncWithoutDetaching($id);
        });
    }

    public function withCategory(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {
            $id = Category::inRandomOrder()->limit(rand(1, 3))->pluck('id');
            $event->categories()->syncWithoutDetaching($id);
        });
    }

    public function withInstances(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {
            $numberOfInstances = rand(0, 3); // 0から3のランダムな数
            for ($i = 0; $i < $numberOfInstances; $i++) {
                $event->instances()->save(Instance::factory()->make());
            }
        });
    }


    public function withFile(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {
            $numberOfFiles = rand(1, 3);
            $files = File::factory()->count($numberOfFiles)->make();
            $event->files()->saveMany($files);
        });
    }

    public function withEventTimeTable(callable $callback = null)
    {
        return $this->afterCreating(function (Event $event) {

            $startDate = new Carbon($event->start_date);
            $endDate = new Carbon($event->end_date);

            while ($startDate->lessThan($endDate)) {
                $duration = rand(30, 60); // 30分から60分のランダムな期間
                $endTime = $startDate->copy()->addMinutes($duration);

                if ($endTime->greaterThanOrEqualTo($endDate)) {
                    break; // 終了時間がイベントの終了時間を超える場合はループを終了
                }

                $eventTimeTable = EventTimeTable::factory()->make([
                    'event_id' => $event->id,
                    'start_date' => $startDate->copy(),
                    'end_date' => $endTime
                ]);
                $event->event_time_tables()->save($eventTimeTable);

                // TimeTablePerformersはrand(1 ,2)の範囲で作成
                TimeTablePerformers::factory()->count(rand(1, 2))->create([
                    'event_time_table_id' => $eventTimeTable->id,
                ]);
                // 次のイベントタイムテーブルの開始時間を設定
                $startDate = $endTime;
                // 4分の1の確率で10分から30分の間隔を開ける
                if (rand(1, 4) === 1) {
                    $additionalMinutes = rand(10, 30);
                    $startDate->addMinutes($additionalMinutes);
                }
            }
        });
    }
}
