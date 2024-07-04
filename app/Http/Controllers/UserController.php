<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Exports\UserExport;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('modules.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'status' => 'required|boolean',
            'password' => 'required|string',
        ]);

        User::create($request->all());

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function update(Request $request, User $user)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'status' => 'nullable|boolean',
        ]);

        $user->update($request->all());
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');

        $users = User::where('id', 'LIKE', "%$searchTerm%")
            ->orWhere('name', 'LIKE', "%$searchTerm%")
            ->orWhere('last_name', 'LIKE', "%$searchTerm%")
            ->orWhere('email', 'LIKE', "%$searchTerm%")
            ->get();

        return view('modules.users.index', compact('users'));
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        User::whereIn('id', $ids)->delete();
        return response()->json(["success" => "Usuarios seleccionados eliminados exitosamente."]);
    }


    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User eliminado exitosamente.');
    }

    public function generatePDF()
    {
        $users = User::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Usuarios',
            'date' => $date,
            'users' => $users
        ];

        $pdf = PDF::loadView('modules.users.pdf', $data);
        $pdfName = "Usuarios - {$date}.pdf";

        return $pdf->download($pdfName);
    }

    public function exportExcel()
    {
        $date = date('d-m-Y H:i:s');
        $excelName = "Usuarios {$date}.xlsx";
        return Excel::download(new UserExport, $excelName);
    }
}
