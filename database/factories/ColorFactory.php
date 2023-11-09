<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;

class ColorFactory extends Factory
{
    protected $model = Color::class;

    public function definition()
    {
        $colors = ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Orange', 'Purple', 'Pink', 'Brown', 'Grey', 'Silver', 'Gold', 'Rose Gold', 'Space Grey', 'Midnight Green', 'Graphite', 'Pacific Blue', 'Coral', 'Lavender', 'Mint Green', 'Midnight Blue', 'Product Red', 'Midnight Green'];
        return [
            'key' => $this->faker->unique()->randomElement($colors),
        ];
    }
}
