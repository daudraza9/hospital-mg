<?php

namespace Database\Factories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'patient_id'=>$this->faker->numberBetween(1,10),
            'doctor_id'=>$this->faker->numberBetween(1,10),
            'fee'=>$this->faker->numberBetween(1,10),
            'date'=>$this->faker->date('Y-m-d'),
            'time'=>$this->faker->time('H:i:s')
        ];
    }
}
