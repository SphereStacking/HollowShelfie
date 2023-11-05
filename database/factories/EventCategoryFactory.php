<?php

namespace Database\Factories;

use App\Models\Category;
use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Event;
use App\Models\EventTag;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EventTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EventTag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
