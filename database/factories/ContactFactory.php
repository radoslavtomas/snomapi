<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_names' => fake()->name(),
            'last_name' => fake()->lastName(),
            'date_of_birth' => fake()->date('d/m/Y'),
            'phone'=> fake()->phoneNumber(),
            'email' => fake()->email()
        ];
    }
}
