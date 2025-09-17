<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+265' . fake()->numberBetween(888000000, 999999999),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'interests' => fake()->randomElements(['pottery', 'weaving', 'woodworking', 'metalwork'], 2),
            'location' => fake()->city(),
            'current_knowledge' => fake()->randomElements(['beginner', 'intermediate', 'advanced'], 1),
            'registration_status' => fake()->randomElement(['pending', 'approved', 'completed']),
            'amount_paid' => fake()->randomElement([0, 7000]),
            'registered_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'is_admin' => false,
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
}
