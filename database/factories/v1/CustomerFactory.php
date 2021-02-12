<?php

namespace Database\Factories\v1;

use App\Models\v1\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_people' => \App\Models\v1\People::all()->unique()->random()->id,
            'id_corporate' => \App\Models\v1\Corporate::all()->unique()->random()->id,
        ];
    }
}
