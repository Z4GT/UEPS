<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Responsible;
use App\Models\Period;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ModuleExport;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::all();
        $responsibles = Responsible::where('status', true)->get(); //solo responsables activos
        $periods = Period::all();
        return view('modules.modules.index', compact('modules', 'responsibles', 'periods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_responsible' => 'required|string|max:255',
            'id_period' => 'required|integer',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vinculation_hours' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        // Obtener el último módulo basado en el id_mod
        $lastModule = Module::orderBy('id_mod', 'desc')->first();
        $lastIdNumber = $lastModule ? intval(substr($lastModule->id_mod, 4)) : 0;
        $newIdNumber = str_pad($lastIdNumber + 1, 2, '0', STR_PAD_LEFT);

        Module::create([
            'id_mod' => 'MOD-' . $newIdNumber,
            'id_responsible' => $request->id_responsible,
            'id_period' => $request->id_period,
            'name' => $request->name,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'vinculation_hours' => $request->vinculation_hours,
            'status' => $request->status,
        ]);

        return redirect()->route('modules.index')->with('success', 'Módulo creado correctamente.');
    }

    public function update(Request $request, $id_mod)
    {
        // dd($request->all());

        $request->validate([
            'id_responsible' => 'required|string|max:255',
            'id_period' => 'required|integer',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'vinculation_hours' => 'required|integer',
            'status' => 'required|boolean',
        ]);

        $module = Module::findOrFail($id_mod);
        $module->update($request->all());

        return redirect()->route('modules.index')->with('success', 'Módulo actualizado correctamente.');
    }

    public function deactivateAll(Request $request)
    {
        $ids = $request->ids;

        // Validar que los IDs sean un array y no estén vacíos
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado módulos."]);
        }

        // Actualizar el campo 'status' a inactivo para los módulos seleccionados
        $modules = Module::whereIn('id_mod', $ids)->get();
        foreach ($modules as $module) {
            $module->update(['status' => 0]);
        }

        return response()->json(["success" => "Módulos seleccionados desactivados exitosamente."]);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        // Validar que los IDs sean un array y no estén vacíos
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado módulos."]);
        }

        // Eliminar los módulos seleccionados
        $modules = Module::whereIn('id_mod', $ids)->get();
        foreach ($modules as $module) {
            $module->delete();
        }

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
