<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'floor_no'=>$this->faker->numberBetween(1,20),
            'room_no'=>$this->faker->numberBetween(1,20),
            'total_bed'=>$this->faker->numberBetween(1,20)
        ];
    }
}
