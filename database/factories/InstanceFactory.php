<?php

namespace Database\Factories;

use App\Models\Instance;
use App\Models\InstanceType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Instance>
 */
class InstanceFactory extends Factory
{
    protected $model = Instance::class;

    public function definition(): array
    {
        return [
            'instance_type_id' => InstanceType::inRandomOrder()->first()->id,
            'display_name' => $this->faker->sentence,
            'access_url' => $this->faker->url,
        ];
    }
}
