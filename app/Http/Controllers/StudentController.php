<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('modules.students.index', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'card_id' => 'required|string|max:10|unique:students',
            'last_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'hours' => 'required|numeric',
        ]);

        // Obtener el último estudiante basado en el id_stud
        $lastStudent = Student::orderBy('id_stud', 'desc')->first();

        // Extraer el número del id_stud y convertirlo a entero
        $lastIdNumber = $lastStudent ? intval(substr($lastStudent->id_stud, 4)) : 0;

        do {
            // Incrementar el número para el nuevo ID
            $newIdNumber = str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
            $newId = 'EST-' . $newIdNumber;

            // Verificar si el ID ya existe
            $exists = Student::where('id_stud', $newId)->exists();

            if ($exists) {
                // Si el ID ya existe, incrementar el número nuevamente
                $lastIdNumber++;
            }
        } while ($exists);

        Student::create([
            'id_stud' => $newId,
            'card_id' => $request->card_id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'course' => $request->course,
            'hours' => $request->hours,
        ]);

        return redirect()->route('students.index')->with('success', 'Estudiante agregado correctamente.');
    }


    public function update(Request $request, $id_stud)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'card_id' => 'required|string|max:10',
            'last_name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
            'hours' => 'required|numeric',
        ]);

        $student = Student::findOrFail($id_stud);
        $student->update($request->all());

        return redirect()->route('students.index')->with('success', 'Estudiante actualizado correctamente.');
    }



    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Student::whereIn('id_stud', $ids)->delete();
        return response()->json(["success" => "Estudiantes seleccionados eliminados exitosamente."]);
    }


    public function destroy($id_stud)
    {
        $student = Student::findOrFail($id_stud);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Estudiante eliminado correctamente.');
    }

    public function generatePDF()
    {

        $students = Student::all();
        $date = date('d/m/Y H:i:s');


        $data = [

            'title' => 'Registros de Estudiantes',
            'date' => date('d/m/Y H:i:s'),
            'students' => $students
        ];

        $pdf = PDF::loadView('modules.students.pdf', $data);
        $pdfName = "Estudiantes - {$date}.pdf";


        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');;
        $excelName = "Estudiantes {$date}.xlsx";
        return Excel::download(new StudentsExport, $excelName);
    }

    public function getModules($id_stud)
    {
        $student = Student::findOrFail($id_stud);
        $modules = $student->modules()->get();

        return response()->json(['modules' => $modules]);
    }
}
