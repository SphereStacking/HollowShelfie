<?php

namespace Database\Factories;

use App\Models\Followable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Followable>
 */
class FollowableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Followable::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // ランダムな User または Team をフォロー対象とする
        $followable = [
            \App\Models\User::class,
            \App\Models\Team::class,
        ][rand(0, 1)];

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()->id,
            'followable_id' => $followable::inRandomOrder()->first()->id,
            'followable_type' => $followable,
        ];
    }
}
