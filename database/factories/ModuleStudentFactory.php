<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Student;
use App\Models\Module;
use App\Models\ModuleStudent;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MOduleStudent>
 */
class ModuleStudentFactory extends Factory
{
    protected $model = ModuleStudent::class;

    public function definition()
    {
        return [
            'id_stud' => Student::inRandomOrder()->first()->id_stud,
            'id_mod' => Module::inRandomOrder()->first()->id_mod,
        ];
    }
}
