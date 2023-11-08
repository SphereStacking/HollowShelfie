<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\EventTimeTable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimeTablePerformers>
 */
class TimeTablePerformersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $modelClass = rand(0, 1) ? User::class : Team::class;
        return [
            'event_time_table_id' => EventTimeTable::inRandomOrder()->first()->id,
            'performable_id' => $modelClass::inRandomOrder()->first()->id,
            'performable_type' => $modelClass
        ];
    }
}
