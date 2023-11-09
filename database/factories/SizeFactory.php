<?php

namespace Database\Factories;

use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;

class SizeFactory extends Factory
{
    protected $model = Size::class;

    public function definition(): array
    {
        $sizes = [
            'S',
            'M',
            'L',
            'XL',
            '2XL',
            '3XL',
        ];

        return [
            'key' => $this->faker->unique()->randomElement($sizes),
        ];
    }
}
