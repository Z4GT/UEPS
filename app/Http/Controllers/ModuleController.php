<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Responsible;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModuleExport;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::with('responsible')->get();
        $responsibles = Responsible::all();
        return view('modules.modules.index', compact('modules', 'responsibles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_responsible' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vinculation_hours' => 'required|integer',
        ]);

        // Obtener el último módulo basado en el id_mod
        $lastModule = Module::orderBy('id_mod', 'desc')->first();
        $lastIdNumber = $lastModule ? intval(substr($lastModule->id_mod, 4)) : 0;
        $newIdNumber = str_pad($lastIdNumber + 1, 2, '0', STR_PAD_LEFT);

        Module::create([
            'id_mod' => 'MOD-' . $newIdNumber,
            'id_responsible' => $request->id_responsible,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'vinculation_hours' => $request->vinculation_hours,
        ]);

        return redirect()->route('modules.index')->with('success', 'Módulo creado correctamente.');
    }

    public function update(Request $request, $id_mod)
    {
        $request->validate([
            'id_responsible' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vinculation_hours' => 'required|integer',
        ]);

        $module = Module::findOrFail($id_mod);
        $module->update($request->all());

        return redirect()->route('modules.index')->with('success', 'Módulo actualizado correctamente.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $modules = Module::where('id_mod', 'LIKE', "%$searchTerm%")
            ->orWhere('name', 'LIKE', "%$searchTerm%")
            ->orWhere('start_date', 'LIKE', "%$searchTerm%")
            ->orWhere('end_date', 'LIKE', "%$searchTerm%")
            ->orWhere('vinculation_hours', 'LIKE', "%$searchTerm%")
            ->get();

        return view('modules.modules.index', compact('modules'));
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Module::whereIn('id_mod', $ids)->delete();
        return response()->json(["success" => "Módulos seleccionados eliminados exitosamente."]);
    }
    public function destroy($id_mod)
    {
        $module = Module::findOrFail($id_mod);
        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Módulo eliminado correctamente.');
    }

    public function generatePDF()
    {
        $modules = Module::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Módulos',
            'date' => $date,
            'modules' => $modules
        ];

        $pdf = PDF::loadView('modules.modules.pdf', $data);
        $pdfName = "Modulos - {$date}.pdf";

        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');
        $excelName = "Modulos {$date}.xlsx";
        return Excel::download(new ModuleExport, $excelName);
    }

    public function getStudents($moduleId)
    {
        $students = Module::findOrFail($moduleId)->students; 
        return response()->json($students);
    }
}
