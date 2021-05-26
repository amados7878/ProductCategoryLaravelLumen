<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => function() {
                return Category::all()->random();
            },

            'product_id' => function() {
                return Product::all()->random();
            },
        ];
    }

 

}

