<?php

namespace Database\Factories;

use App\Models\Category;
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
    public function withCategory()
    {
        return $this->state([
            'category_id' => Category::factory()
        ]);
    }
    public function definition()
    {
        return [
            'product_name' => fake()->word() . " " . fake()->word,
            'price' => 2000,
            'price_discount' => 1500,
            'image' => fake()->imageUrl,
            'short_description' => fake()->text,
            'long_description' => fake()->text,
        ];
    }
}