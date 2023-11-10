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
        return [
            'event_id' => Event::inRandomOrder()->first()->id,
            'description' =>  $this->faker->text(10),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months')
        ];
    }
}
