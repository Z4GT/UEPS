<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ModuleStudent;
use App\Models\Student;
use App\Models\Module;

class ModStudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $students = Student::all();
        $modules = Module::all();
        $combinations = [];
        $totalCombinations = 100; // Número total de combinaciones deseadas

        while (count($combinations) < $totalCombinations) {
            $student = $students->random();
            $module = $modules->random();

            // Crear una combinación única
            $combination = [
                'id_stud' => $student->id_stud,
                'id_mod' => $module->id_mod
            ];

            // Asegurarse de no insertar duplicados
            if (!ModuleStudent::where($combination)->exists() && !in_array($combination, $combinations)) {
                ModuleStudent::create($combination);
                $combinations[] = $combination; // Marcar esta combinación como usada
            }
        }
    }
}
