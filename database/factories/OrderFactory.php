<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{


    public function configure(): static
    {
        return $this->afterMaking(function (Order $order) {
            // ...
        })->afterCreating(function (Order $order) {
            // ...
            $notification = new Notification();
            $notification->message = 'تم عمل اوردر جديد باسم ' . $order->username;
            $order->notification()->save($notification);
        });
    }
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
            'user_id' => User::factory(),
            'order_status' => 0,

        ];
    }
}