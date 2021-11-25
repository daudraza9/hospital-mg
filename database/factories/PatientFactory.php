<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

class PatientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Patient::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'first_name'=>$this->faker->name(),
            'last_name'=>$this->faker->name(),
            'email'=>$this->faker->email(),
            'phone'=>$this->faker->phoneNumber(),
            'age'=>$this->faker->biasedNumberBetween(1,100),
            'weight'=>$this->faker->biasedNumberBetween(1,100),
            'address'=>$this->faker->address(),
            'disease'=>$this->faker->word(),
            'gender'=>$this->faker->word()
        ];
    }
}
