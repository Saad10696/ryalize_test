<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'location_id' => Location::inRandomOrder()->first()->id,
            'amount' => fake()->randomFloat(2, 10, 100000),
            'type' => fake()->randomElement(['credit', 'debit']),
            'created_at' => fake()->dateTimeBetween('-2 year', 'now'),
            'updated_at' => fake()->dateTimeBetween('-2 year', 'now'),
        ];
    }
}
