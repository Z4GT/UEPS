<?php

namespace App\Http\Controllers;

use App\Models\Responsible;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResponsibleExport;

class ResponsibleController extends Controller
{
    public function index(Request $request)
    {
        $sortField = $request->get('sort', 'id_responsible'); // Campo por defecto
        $sortDirection = $request->get('direction', 'asc'); // Dirección por defecto

        // Validar los campos de ordenamiento para evitar inyecciones SQL
        $validSortFields = ['id_responsible', 'card_id', 'name', 'last_name', 'area', 'role', 'status'];
        if (!in_array($sortField, $validSortFields)) {
            $sortField = 'id_responsible';
        }

        $responsibles = Responsible::all();
        $users = User::where('status', true)->get(); // Solo usuarios activos

        return view('modules.responsibles.index', compact('responsibles', 'users', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_id' => 'required|string|max:10',
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required|boolean',
            'id_user' => 'nullable|exists:users,id',
        ]);

        // Obtener el último responsable basado en el id_responsible
        $lastResponsible = Responsible::orderBy('id_responsible', 'desc')->first();

        // Extraer el número del id_responsible y convertirlo a entero
        $lastIdNumber = $lastResponsible ? intval(substr($lastResponsible->id_responsible, 5)) : 0;

        do {
            // Incrementar el número para el nuevo ID
            $newIdNumber = str_pad($lastIdNumber + 1, 3, '0', STR_PAD_LEFT);
            $newId = 'RESP-' . $newIdNumber;

            // Verificar si el ID ya existe
            $exists = Responsible::where('id_responsible', $newId)->exists();

            if ($exists) {
                // Si el ID ya existe, incrementar el número nuevamente
                $lastIdNumber++;
            }
        } while ($exists);

        Responsible::create([
            'id_responsible' => $newId,
            'card_id' => $request->card_id,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'area' => $request->area,
            'role' => $request->role,
            'status' => $request->status,
            'id_user' => $request->id_user,
        ]);

        return redirect()->back()->with('success', 'Responsable agregado correctamente.');
    }


    public function update(Request $request, $id_responsible)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'card_id' => 'required|string|max:10',
            'last_name' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'status' => 'required|boolean',
            'id_user' => 'nullable|exists:users,id',
        ]);

        $responsible = Responsible::findOrFail($id_responsible);
        $responsible->update($request->all());

        return redirect()->route('responsibles.index')->with('success', 'Responsable actualizado correctamente.');
    }


    public function deactivateAll(Request $request)
    {
        $ids = $request->ids;

        // Validar que los IDs sean un array y no estén vacíos
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado responsables."]);
        }

        // Actualizar el campo 'status' a inactivo para los responsables seleccionados
        $responsibles = Responsible::whereIn('id_responsible', $ids)->get();
        foreach ($responsibles as $responsible) {
            $responsible->update(['status' => 0]);
        }

        return response()->json(["success" => "Responsables seleccionados desactivados exitosamente."]);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        // Validar que los IDs sean un array y no estén vacíos
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado responsables."]);
        }

        // Eliminar los responsables seleccionados
        $responsibles = Responsible::whereIn('id_responsible', $ids)->get();
        foreach ($responsibles as $responsible) {
            $responsible->delete();
        }

        return response()->json(["success" => "Responsables seleccionados eliminados exitosamente."]);
    }


    public function destroy($id_responsible)
    {
        $responsible = Responsible::findOrFail($id_responsible);
        $responsible->delete();

        return redirect()->route('responsibles.index')->with('success', 'Responsable eliminado correctamente.');
    }

    public function generatePDF()
    {
        $responsibles = Responsible::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Responsables',
            'date' => $date,
            'responsibles' => $responsibles
        ];

        $pdf = PDF::loadView('modules.responsibles.pdf', $data);
        $pdfName = "Responsables - {$date}.pdf";

        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');
        $excelName = "Responsables {$date}.xlsx";
        return Excel::download(new ResponsibleExport, $excelName);
    }
}
