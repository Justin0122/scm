<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Category::factory(4)->create();
        \App\Models\Supplier::factory(7)->create();
//        \App\Models\Product::factory(10)->create();
        \App\Models\Size::factory(6)->create();
        \App\Models\Color::factory(2)->create();

        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
        ]);

        $productNames = ['coveralls', 'white polo', 'safety shoes', 'rain coat', 'travel kit', 'eco bag', 'parka', 'ppe', 'pants', 'cck pants', 'catering polo'];

        $product = \App\Models\Product::create([
            'name' => 'coveralls',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'coveralls description',
        ]);

        $product->suppliers()->attach(\App\Models\Supplier::where('name', 'NSB')->first()->id, [
            'stock' => rand(1, 10),
        ]);

        $product = \App\Models\Product::create([
            'name' => 'white polo',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'white polo description',
        ]);

        $product->suppliers()->attach(\App\Models\Supplier::where('name', 'NSB')->first()->id, [
            'stock' => rand(1, 10),
        ]);

        $product = \App\Models\Product::create([
            'name' => 'safety shoes',
            'category_id' => \App\Models\Category::where('name', 'footwear')->first()->id,
            'description' => 'safety shoes description',
        ]);

        $product->suppliers()->attach(\App\Models\Supplier::where('name', 'NSB')->first()->id, [
            'stock' => rand(1, 10),
        ]);

    }
}
