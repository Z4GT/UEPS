<?php

namespace App\Http\Controllers;

use App\Models\Kardex;
use Illuminate\Http\Request;
use App\Models\OperationType;
use App\Models\Warehouse;
use App\Models\Project;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KardexExport;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsible;

class KardexController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->hasRole('jefe de proyecto')) {
            $responsible = Responsible::where('id_user', $user->id)->first();

            if ($responsible) {
                $projectIds = Project::where('id_responsible', $responsible->id_responsible)->pluck('id_pro');
                $kardexEntries = Kardex::whereIn('id_pro', $projectIds)->orderBy('date', 'asc')->get();
                $projects = Project::whereIn('id_pro', $projectIds)->get();
            } else {
                $kardexEntries = collect(); // Empty collection if no responsible found
                $projects = collect(); // Empty collection if no responsible found
            }
        } else {
            $kardexEntries = Kardex::orderBy('date', 'asc')->get();
            $projectIds = $kardexEntries->pluck('id_pro')->unique();
            $projects = Project::whereIn('id_pro', $projectIds)->get();
        }

        $operationTypes = OperationType::all();
        $warehouses = Warehouse::all();
        $items = Item::all();

        return view('modules.kardex.index', compact('kardexEntries', 'operationTypes', 'warehouses', 'projects', 'items'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'id_ope' => 'required|integer',
            'id_ware' => 'required|string|max:255',
            'id_pro' => 'required|string|max:255',
            'id_item' => 'required|string|max:255',
            'detail' => 'required|string',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'balance' => 'required|integer|min:0',
        ]);

        $lastKardex = Kardex::orderBy('created_at', 'desc')->first();
        $lastIdNumber = $lastKardex ? intval(substr($lastKardex->id_kardex, 7)) : 0;
        $newIdNumber = str_pad($lastIdNumber + 1, 4, '0', STR_PAD_LEFT);

        Kardex::create([
            'id_kardex' => 'KARDEX-' . $newIdNumber,
            'id_ope' => $request->id_ope,
            'id_ware' => $request->id_ware,
            'id_pro' => $request->id_pro,
            'id_item' => $request->id_item,
            'detail' => $request->detail,
            'date' => $request->date,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'balance' => $request->balance,
        ]);

        return redirect()->back()->with('success', 'Registro de kardex creado correctamente.');
    }

    public function show($id)
    {
        $kardex = Kardex::with(['operationType', 'warehouse', 'project'])->findOrFail($id);
        return view('kardex.show', compact('kardex'));
    }

    public function edit($id)
    {
        $kardex = Kardex::findOrFail($id);
        $operationTypes = OperationType::all();
        $warehouses = Warehouse::all();
        $projects = Project::all();
        return view('kardex.edit', compact('kardex', 'operationTypes', 'warehouses', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $kardex = Kardex::findOrFail($id);

        $request->validate([
            'id_ope' => 'required|integer',
            'id_ware' => 'required|string|max:255',
            'id_pro' => 'required|string|max:255',
            'id_item' => 'required|string|max:255',
            'detail' => 'required|string',
            'date' => 'required|date',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'balance' => 'required|integer|min:0',
        ]);

        $kardex->update($request->all());

        return redirect()->back()->with('success', 'Registro de kardex actualizado correctamente.');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No items selected."]);
        }

        Kardex::whereIn('id_kardex', $ids)->delete();

        return response()->json(["success" => "Entradas de kardex seleccionadas eliminadas exitosamente."]);
    }

    public function destroy($id)
    {
        $kardex = Kardex::findOrFail($id);
        $kardex->delete();

        return redirect()->route('kardex.index')->with('success', 'Entrada de kardex eliminada exitosamente.');
    }

    public function generatePDF()
    {
        // Ordena los registros por fecha en orden descendente
        $kardexEntries = Kardex::orderBy('date', 'desc')->get();
        $date = date('d/m/Y H:i:s');
    
        $data = [
            'title' => 'Registros de kardex',
            'date' => $date,
            'kardexEntries' => $kardexEntries
        ];
    
        $pdf = PDF::loadView('modules.kardex.pdf', $data)
            ->setPaper('a4', 'landscape');
        $pdfName = "Kardex - {$date}.pdf";
    
        return $pdf->download($pdfName);
    }
    

    // public function exportExcel()
    // {
    //     $date = date('d-m-Y H:i:s');
    //     $excelName = "Kardex {$date}.xlsx";
    //     return Excel::download(new KardexExport, $excelName);
    // }
}
