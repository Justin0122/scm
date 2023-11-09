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
        \App\Models\DataType::factory(6)->create();
        \App\Models\Specification::factory(2)->create();
//        \App\Models\ProductSpecification::factory(6)->create();

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

// Get the IDs of the suppliers
        $supplierIds = [
            \App\Models\Supplier::where('name', 'NSB')->first()->id,
            \App\Models\Supplier::where('name', 'ATLANSHIP')->first()->id,
            \App\Models\Supplier::where('name', 'CSM')->first()->id,
            \App\Models\Supplier::where('name', 'CTM')->first()->id,
            \App\Models\Supplier::where('name', 'SAFEEN')->first()->id,
        ];

        $sizes = ['S', 'M', 'L', 'XL', '2XL', '3XL'];

// Get the IDs of specifications
        $colorSpecificationId = \App\Models\Specification::where('key', 'color')->first()->id;
        $sizeSpecificationId = \App\Models\Specification::where('key', 'size')->first()->id;

// Attach suppliers and specifications
        $product->suppliers()->attach($supplierIds);
        $product->specifications()->attach([
            $colorSpecificationId => ['specification_value' => 'Blue'],
            $sizeSpecificationId => ['specification_value' => 'S'],
        ]);


        $product = \App\Models\Product::create([
            'name' => 'white polo',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'white polo description',

        ]);
        $product->specifications()->attach([
            $colorSpecificationId => ['specification_value' => 'White'],
        ]);
        foreach ($sizes as $size) {
            $product->specifications()->attach([
                $sizeSpecificationId => ['specification_value' => $size],
            ]);
        }

        $product = \App\Models\Product::create([
            'name' => 'safety shoes',
            'category_id' => \App\Models\Category::where('name', 'footwear')->first()->id,
            'description' => 'safety shoes description',

        ]);

        $shoesizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45', '46', '47'];
        foreach ($shoesizes as $size) {
            $product->specifications()->attach([
                $sizeSpecificationId => ['specification_value' => $size],
            ]);
        }

        $product = \App\Models\Product::create([
            'name' => 'rain coat',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'rain coat description',

        ]);

        foreach ($sizes as $size) {
            $product->specifications()->attach([
                $sizeSpecificationId => ['specification_value' => $size],
            ]);
        }

        $product = \App\Models\Product::create([
            'name' => 'travel kit',
            'category_id' => \App\Models\Category::where('name', 'accessories')->first()->id,
            'description' => 'travel kit description',

        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'NSB')->first()->id,
            \App\Models\Supplier::where('name', 'CSM')->first()->id,
        ]);

        $product = \App\Models\Product::create([
            'name' => 'eco bag',
            'category_id' => \App\Models\Category::where('name', 'accessories')->first()->id,
            'description' => 'eco bag description',

        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'NSB')->first()->id,
            \App\Models\Supplier::where('name', 'CSM')->first()->id,
        ]);

        $product = \App\Models\Product::create([
            'name' => 'parka',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'parka description',

        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'FS')->first()->id,
        ]);
        $product->save();

        $product = \App\Models\Product::create([
            'name' => 'ppe',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'ppe description',

        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'FS')->first()->id,
        ]);

        $product->save();

        $product = \App\Models\Product::create([
            'name' => 'black pants',
            'category_id' => \App\Models\Category::where('name', 'bottoms')->first()->id,
            'description' => 'pants description',
        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'MSM')->first()->id,
        ]);
        $pants_sizes = ['30', '31', '32', '33', '34', '35', '36', '37', '38', '39', '40', '42'];
        foreach ($pants_sizes as $size) {
            $product->specifications()->attach([
                $sizeSpecificationId => ['specification_value' => $size],
            ]);
        }

        $product = \App\Models\Product::create([
            'name' => 'cck pants',
            'category_id' => \App\Models\Category::where('name', 'bottoms')->first()->id,
            'description' => 'cck pants description',

        ]);
        foreach ($pants_sizes as $size) {
            $product->specifications()->attach([
                $sizeSpecificationId => ['specification_value' => $size],
            ]);
        }

        $product = \App\Models\Product::create([
            'name' => 'catering polo',
            'category_id' => \App\Models\Category::where('name', 'tops')->first()->id,
            'description' => 'catering polo description',

        ]);
        $product->suppliers()->attach([
            \App\Models\Supplier::where('name', 'MSM')->first()->id,
        ]);

        $product->save();

        \App\Models\ProductStock::factory(10)->create();

    }
}
