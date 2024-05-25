<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Link;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\ConnectedAccount;
use JoelButcher\Socialstream\Providers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features as JetstreamFeatures;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }


    /**
     * Indicate that the user should have links.
     */
    public function withLink(callable $callback = null): static
    {
        return $this->has(
            Link::factory()->count(rand(1, 4))->when(is_callable($callback), $callback),
            'links'
        );
    }

    public function withTag(callable $callback = null): static
    {
        return $this->has(
            Tag::factory()->count(rand(1, 4))->when(is_callable($callback), $callback),
            'tags'
        );
    }

    /**
     * Indicate that the user should have a personal team.
     */
    public function withPersonalTeam(callable $callback = null): static
    {
        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }

    /**
     * Indicate that the user should have a connected account for the given provider.
     */
    public function withConnectedAccount(string $provider, callable $callback = null): static
    {
        if (! Providers::enabled($provider)) {
            return $this->state([]);
        }

        return $this->has(
            ConnectedAccount::factory()
                ->state(fn (array $attributes, User $user) => [
                    'provider' => $provider,
                    'user_id' => $user->id,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
