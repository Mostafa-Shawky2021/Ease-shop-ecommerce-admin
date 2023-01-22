<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cat_name' => Str::random(8),
            'description' => Str::random(20),
            'image' => "https://www.freepnglogos.com/uploads/laptop-png/laptop-transparent-png-pictures-icons-and-png-40.png",
        ];
    }
}