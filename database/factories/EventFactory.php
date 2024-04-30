<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\File;
use App\Models\User;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Arr;
use App\Models\EventTimeTable;
use App\Models\TimeTablePerformers;
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
        $status = Arr::random(EventStatus::cases());
        return [
            'event_create_user_id' => User::inRandomOrder()->first()->id,
            'title' => $this->faker->text(20),
            'start_date' => $formattedDateTime,
            'end_date' => $endDateTime,
            'description' => $this->faker->paragraphs(5, true),
            'status' => $status,
            'published_at' => function () use ($status) {
                switch ($status) {
                    case EventStatus::UPCOMING:
                        return $this->faker->dateTimeBetween('0 month', '+1 month');
                    case EventStatus::ONGOING:
                        return Carbon::now();
                    case EventStatus::SCHEDULED:
                        return $this->faker->dateTimeBetween('+1 month', '+2 month');
                    case EventStatus::CANCELED:
                    case EventStatus::CLOSED:
                    case EventStatus::DRAFT:
                        return;
                    default:
                        return;
                }
            },
            'alias' => $this->faker->unique()->slug(2),
        ];
    }

    public function withFile()
    {
        return $this->afterCreating(function (Event $event) {
            $event->files()->save(File::factory()->make());
        });
    }

    public function withEventTimeTable()
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
