<?php

namespace Database\Factories;

use App\Enums\EventStatus;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

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
        $dateTime = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $formattedDateTime = Carbon::instance($dateTime)->format('Ymd\THis\Z');

        // 開始時間から2時間後を終了時間とする
        $endDateTime = Carbon::instance($dateTime)->addHours(2)->format('Ymd\THis\Z');
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
                        return null;
                    default:
                        return null;
                }
            },
        ];
    }

    /**
     * Indicate that the event should have a file.
     *
     * @return $this
     */
    public function withFile()
    {
        return $this->afterCreating(function (Event $event) {
            $event->files()->save(File::factory()->make());
        });
    }
}
