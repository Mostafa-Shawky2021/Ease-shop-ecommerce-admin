<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => 13,
            'product_name' => Str::random(20) . " " . Str::random(5),
            'price' => 2000,
            'price_discount' => 1500,
            // 'image' => 'https://www.pngplay.com/wp-content/uploads/7/Android-Mobile-Download-Free-PNG.png',
            'brand' => Str::random(7),
            'short_description' => Str::random(20),
            'long_description' => Str::random(30),
        ];
    }
}