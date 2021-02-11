<?php

namespace Database\Factories\v1;

use App\Models\v1\People;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = People::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'birthdate' => $this->faker->date(),
            'age' => $this->faker->numberBetween(20, 50),
            'sex' => $this->faker->randomElement($array = array ('F','M')),
        ];
    }
}
