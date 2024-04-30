<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\EventTimeTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventTimeTable>
 */
class EventTimeTableFactory extends Factory
{
    protected $model = EventTimeTable::class;

    public function definition(): array
    {
        // 開始時間として16:00から18:00の間でランダムな時間を生成
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month')->setTime(rand(16, 18), 0);
        // 終了時間として開始時間から最大2時間後の時間を生成
        $endDate = (clone $startDate)->modify('+'.rand(0, 120).' minutes');

        return [
            'event_id' => Event::inRandomOrder()->first()->id,
            'description' => $this->faker->text(10),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
