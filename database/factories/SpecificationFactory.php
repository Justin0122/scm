<?php

namespace Database\Factories;

use App\Models\Specification;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpecificationFactory extends Factory
{
    protected $model = Specification::class;

    public function definition()
    {
        $specs = ['size', 'color'];
        return [
            'key' => $this->faker->unique()->randomElement($specs),
            'data_type_id' => $this->faker->numberBetween(1, 6),
        ];
    }
}
