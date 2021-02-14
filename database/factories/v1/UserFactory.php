<?php

namespace Database\Factories\v1;

use App\Models\v1\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $rand_people = \App\Models\v1\People::all();
        $people_id = [];

        foreach ($rand_people as $value)
            array_push($people_id, $value->id);

        return [
            'id_people' => $this->faker->unique()->randomElement($people_id),
            'username' => $this->faker->userName,
            'password' => Hash::make('admin'),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
