<?php

namespace Database\Factories;

use App\Models\ProductStock;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductStockFactory extends Factory
{
    protected $model = ProductStock::class;

    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 10),
            'specification_id' => $this->faker->numberBetween(1, 2),
            'specification_value' => $this->faker->randomElement(['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White']),
            'supplier_id' => $this->faker->numberBetween(1, 7),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
