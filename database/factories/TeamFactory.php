<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Link;
use App\Models\User;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::factory(),
            'personal_team' => true,
        ];
    }

    public function withLink(callable $callback = null): static
    {
        return $this->afterCreating(function (Team $team) use ($callback) {
            $team->links()->saveMany(
                Link::factory()->count(rand(1, 4))->when(is_callable($callback), $callback)->make()
            );
        });
    }

    public function withTag(callable $callback = null): static
    {
        return $this->afterCreating(function (Team $team) use ($callback) {
            $team->tags()->saveMany(
                Tag::factory()->count(rand(1, 4))->when(is_callable($callback), $callback)->make()
            );
        });
    }
}
