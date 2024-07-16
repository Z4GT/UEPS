<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class ApiStudentController extends Controller

{

    public function index(Request $request)
    {
        return Student::all();
    }


    public function store(Request $request)
    {
        $lastStudent = Student::orderBy('id_stud', 'desc')->first();

        $lastIdNumber = $lastStudent ? intval(substr($lastStudent->id_stud, 4)) : 0;

        do {
            $newIdNumber = str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
            $newId = 'EST-' . $newIdNumber;

            $exists = Student::where('id_stud', $newId)->exists();

            if ($exists) {
                $lastIdNumber++;
            }
        } while ($exists);

        $student = Student::create([
            'id_stud' => $newId,
            'card_id' => $request->card_id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'hours' => $request->hours,
            'status' => $request->status,
        ]);

        return response()->json('Estudiante ' . $student . ' Agregado', 201);
    }


    public function update(Request $request, $id_stud)
    {
        // Buscar el estudiante existente
        $student = Student::findOrFail($id_stud);

        // Actualizar el estudiante con los nuevos datos
        $student->update($request->all());

        // Retornar la respuesta con el estudiante actualizado y código 200 (OK)
        return response()->json('Estudiante ' . $student . ' Actualizado', 200);
    }



    public function destroy($id_stud)
    {
        // Buscar el estudiante existente
        $student = Student::findOrFail($id_stud);

        // Eliminar el estudiante
        $student->delete();

        // Retornar la respuesta sin contenido y código 204 (No Content)
        return response()->json('Estudiante ' . $student . ' Eliminado', 200);
    }
}
