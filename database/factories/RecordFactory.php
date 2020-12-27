<?php

namespace Database\Factories;

use App\Models\Record;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Record::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date'      => $this->faker->date(),
            'weight'    => $this->faker->randomFloat(2, $min = 60,$max = 70),
            'step'      => $this->faker->numberBetween($min = 1000,$max = 5000),
            'exercise'  => $this->faker->text($maxNbChars = 5),
        ];
    }
}
