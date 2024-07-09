<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SecurityQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            '¿Cuál es el nombre de soltera de tu madre?',
            '¿Cuál fue el nombre de tu primera mascota?',
            '¿Cuál fue la marca y modelo de tu primer coche?',
            '¿A qué escuela primaria asististe?',
            '¿En qué ciudad naciste?'
        ];

        foreach ($questions as $question) {
            DB::table('security_questions')->insert([
                'question' => $question,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
