<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    protected $model = Student::class;
    private static $idCounter = 1;

    public function definition()
    {
        $id = 'EST-' . str_pad(self::$idCounter++, 2, '0', STR_PAD_LEFT);

        return [
            'id_stud' => $id,
            'card_id' => $this->faker->numerify('##########'),
            'name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'status' => $this->faker->boolean,
        ];
    }
}
