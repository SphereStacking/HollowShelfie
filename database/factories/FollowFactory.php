<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Follow>
 */
class FollowFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Follow::class;

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
            'user_id' => \App\Models\User::factory(),
            'followable_id' => $followable::factory(),
            'followable_type' => $followable,
        ];
    }
}
