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
            'product_name' => Str::random(20) . " " . Str::random(5),
            'price' => 2000,
            'price_discount' => 1500,
            'image' => 'https://www.zdnet.com/a/img/resize/89ad80ef5e62511b5aa4a3fe55a1e0b81463995d/2022/10/05/3d233bf8-95fc-4c1a-98a2-1bfebe867fa0/macbook-air-m2-2022-770x433.jpg?auto=webp&fit=crop&height=360&width=640',
            'short_description' => Str::random(20),
            'long_description' => Str::random(30),
        ];
    }
}