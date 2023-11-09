<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        $supplierNames = ['NSB', 'ATLANSHIP', 'CSM', 'CTM', 'SAFEEN', 'FS', 'MSM'];

        return [
            'name' => $this->faker->unique()->randomElement($supplierNames),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];
    }
}
