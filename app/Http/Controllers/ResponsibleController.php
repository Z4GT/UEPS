<?php

namespace App\Http\Controllers;

use App\Models\Responsible;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ResponsibleExport;

class ResponsibleController extends Controller
{
    public function index()
    {
        $responsibles = Responsible::all();
        return view('modules.responsibles.index', compact('responsibles'));
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
        ]);

        // Verificar si la solicitud proviene del modal de módulos
        if ($request->has('from_module') && $request->input('from_module') == 'true') {
            return redirect()->route('modules.index')->with('success', 'Responsable agregado correctamente.');
        }

        return redirect()->route('responsibles.index')->with('success', 'Responsable agregado correctamente.');
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
        ]);

        $responsible = Responsible::findOrFail($id_responsible);
        $responsible->update($request->all());

        return redirect()->route('responsibles.index')->with('success', 'Responsable actualizado correctamente.');
    }


    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        Responsible::whereIn('id_responsible', $ids)->delete();
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
