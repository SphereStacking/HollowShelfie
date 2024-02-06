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
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventTimeTable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 開始時間として16:00から18:00の間でランダムな時間を生成
        $startTime = $this->faker->time($format = 'H:i:s', $max = '18:00:00');
        // 終了時間として開始時間から最大2時間後の時間を生成
        $endTime = date('H:i:s', strtotime($startTime) + rand(1, 2) * 3600);

        return [
            'event_id' => Event::inRandomOrder()->first()->id,
            'description' =>  $this->faker->text(10),
            'start_time' => $startTime,
            'end_time' => $endTime
        ];
    }
}
