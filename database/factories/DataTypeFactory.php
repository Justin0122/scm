<?php

namespace Database\Factories;

use App\Models\DataType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataTypeFactory extends Factory
{
    protected $model = DataType::class;

    public function definition()
    {
        $names = ['string', 'integer', 'float', 'boolean', 'date', 'datetime'];
        //make sure the name is unique
        return [
            'name' => $this->faker->unique()->randomElement($names),
        ];
    }
}
