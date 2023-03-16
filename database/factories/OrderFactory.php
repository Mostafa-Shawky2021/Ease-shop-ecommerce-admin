<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'invoice_number' => Str::random(5),
            'username' => fake()->userName(),
            'phone' => fake()->phoneNumber(),
            'governorate' => fake()->streetName(),
            'street' => fake()->streetAddress(),
            'email' => fake()->email(),
            'order_notes' => Str::random(15),
            'total_price' => 2500,
            'user_id' => 1,
            'order_status' => 0,

        ];
    }
}