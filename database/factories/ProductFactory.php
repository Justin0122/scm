<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $productNames = ['coveralls', 'polo', 'safety shoes', 'rain coat', 'travel kit', 'eco bag', 'parka', 'ppe', 'pants', 'cck pants', 'catering polo'];
        return [
            'name' => $this->faker->unique()->randomElement($productNames),
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => $this->faker->text(200),
        ];
    }
}
