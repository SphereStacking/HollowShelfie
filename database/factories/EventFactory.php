<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Enums\EventStatus;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EventFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Event::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateTime = $this->faker->dateTimeThisMonth;
        $formattedDateTime = Carbon::instance($dateTime)->format('Ymd\THis\Z');

        // 開始時間から2時間後を終了時間とする
        $endDateTime = Carbon::instance($dateTime)->addHours(2)->format('Ymd\THis\Z');

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'organizer_id' => User::inRandomOrder()->first()->id,
            'title' => $this->faker->sentence,
            'location' => $this->faker->address,
            'start_date' => $formattedDateTime,
            'end_date' => $endDateTime,
            'description' => $this->faker->paragraph,
            'status' => Arr::random(EventStatus::getAllStatuses()),
        ];
    }
}
