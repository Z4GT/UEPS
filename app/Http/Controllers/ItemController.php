<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\CategoryItem;
use App\Models\MeasurementUnit;
use App\Models\Project;
use App\Models\Module;
use App\Models\Responsible;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ItemExport;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    // public function index()
    // {
    //     $items = Item::all();
    //     $categories = CategoryItem::all();
    //     $units = MeasurementUnit::all();
    //     $projects = Project::all();
    //     return view('modules.items.index', compact('items', 'categories', 'units', 'projects'));
    // }

    public function index(Request $request)
    {
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'asc');

        /** @var \App\Models\User */
        $user = Auth::user();

        if ($user->hasRole('jefe de proyecto')) {
            $responsible = Responsible::where('id_user', $user->id)->first();

            if ($responsible) {
                $projectIds = Project::where('id_responsible', $responsible->id_responsible)->pluck('id_pro');
                $items = Item::whereIn('id_pro', $projectIds)->orderBy($sortField, $sortDirection)->get();
                $projects = Project::whereIn('id_pro', $projectIds)->get();
            } else {
                $items = collect(); // Empty collection if no responsible found
                $projects = collect(); // Empty collection if no responsible found
            }
        } else {
            $items = Item::orderBy($sortField, $sortDirection)->get();
            $projectIds = $items->pluck('id_pro')->unique();
            $projects = Project::whereIn('id_pro', $projectIds)->get();
        }

        $categories = CategoryItem::all();
        $units = MeasurementUnit::all();

        return view('modules.items.index', compact('items', 'categories', 'units', 'projects', 'sortField', 'sortDirection'));
    }


    public function list()
    {
        $items = Item::with('categoryItem', 'measurementUnit', 'project')->get();
        return view('modules.items.list', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_catitem' => 'required|string|max:255',
            'id_unit' => 'required|string|max:255',
            'id_pro' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'stock' => 'required|integer|min:0',
        ]);

        $lastItem = Item::orderBy('created_at', 'desc')->first();
        $lastIdNumber = $lastItem ? intval(substr($lastItem->id_item, 5)) : 0;
        $newIdNumber = str_pad($lastIdNumber + 1, 4, '0', STR_PAD_LEFT);

        $item = Item::create([
            'id_item' => 'ITEM-' . $newIdNumber,
            'id_catitem' => $request->id_catitem,
            'id_unit' => $request->id_unit,
            'id_pro' => $request->id_pro,
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'stock' => $request->stock,
        ]);

        if ($request->has('tags')) {
            $item->attachTags($request->tags);
        }

        return redirect()->back()->with('success', 'Ítem creado correctamente.');
    }

    public function show($id)
    {
        $item = Item::with('categoryItem', 'measurementUnit', 'project')->findOrFail($id);
        return view('items.show', compact('item'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categoryItems = CategoryItem::all();
        $measurementUnits = MeasurementUnit::all();
        $projects = Project::all();
        return view('items.edit', compact('item', 'categoryItems', 'measurementUnits', 'projects'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'id_catitem' => 'required|string|max:255',
            'id_unit' => 'required|string|max:255',
            'id_pro' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'stock' => 'required|integer|min:0',
        ]);

        $item->update([
            'id_catitem' => $request->id_catitem,
            'id_unit' => $request->id_unit,
            'id_pro' => $request->id_pro,
            'name' => $request->name,
            'description' => $request->description,
            'date' => $request->date,
            'stock' => $request->stock,
        ]);

        if ($request->has('tags')) {
            $item->syncTags($request->tags);
        }

        return redirect()->back()->with('success', 'Ítem actualizado correctamente.');
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if (!is_array($ids) || empty($ids)) {
            return response()->json(["error" => "No se han seleccionado ítems."]);
        }

        $items = Item::whereIn('id_item', $ids)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        return response()->json(["success" => "Ítems seleccionados eliminados exitosamente."]);
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Ítem eliminado correctamente.');
    }

    public function getTags($id)
    {
        $item = Item::findOrFail($id);
        return response()->json(['tags' => $item->tags->pluck('name')]);
    }

    public function generatePDF()
    {
        $items = Item::all();
        $date = date('d/m/Y H:i:s');
    
        $data = [
            'title' => 'Registros de Ítems',
            'date' => $date,
            'items' => $items
        ];
    
        $pdf = PDF::loadView('modules.items.pdf', $data);
    
        // Formatear la fecha para que no contenga caracteres no permitidos en el nombre del archivo
        $formattedDate = date('Y-m-d_H-i-s');
        $pdfName = "Items_{$formattedDate}.pdf";
    
        return $pdf->download($pdfName);
    }
    

    // public function exportExcel()
    // {
    //     $date = date('d-m-Y H:i:s');
    //     $excelName = "Ítems {$date}.xlsx";
    //     return Excel::download(new ItemExport, $excelName);
    // }
}
