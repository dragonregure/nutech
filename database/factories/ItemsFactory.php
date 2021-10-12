<?php

namespace Database\Factories;

use App\Models\Items;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Items::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->sentence(2),
            'buyprice' => $this->faker->randomNumber(),
            'sellprice' => $this->faker->randomNumber(),
            'stock' => $this->faker->randomNumber(),
            'path' => '/images/example.jpg',
        ];
    }
}
