<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{

    public function configure(): static
    {
        return $this->afterMaking(function (Message $message) {
            // ...
        })->afterCreating(function (Message $message) {
            // ...
            $notification = new Notification();
            $notification->message = "تم ارسال رسالة جديدة بواسطة {$message->username}";
            $message->notification()->save($notification);
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
            'username' => fake()->name(),
            'email' => fake()->email(),
            'message' => fake()->text(),
            'phone' => fake()->phoneNumber(),

        ];
    }
}