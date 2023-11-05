<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Event;
use App\Models\EventTag;
use App\Models\Instance;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\InstanceType;
use Laravel\Jetstream\Features;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class InstanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Instance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'instance_type_id' => InstanceType::inRandomOrder()->first()->id,
            'location' => $this->faker->address,
        ];
    }
}
