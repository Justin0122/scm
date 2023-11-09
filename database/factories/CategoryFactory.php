<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $categoryNames = ['tops', 'bottoms', 'footwear', 'accessories'];

        return [
            'name' => $this->faker->unique()->randomElement($categoryNames),
        ];
    }
}
