<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use App\Models\Event;
use App\Models\EventOrganizer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventOrganizer>
 */
class EventOrganizerFactory extends Factory
{
    protected $model = EventOrganizer::class;

    public function definition(): array
    {
        $modelClass = rand(0, 1) ? User::class : Team::class;
        return [
            'event_id' => Event::factory(),
            'event_organizeble_type' => $modelClass,
            'event_organizeble_id' => $modelClass::factory(),
        ];
    }

}
