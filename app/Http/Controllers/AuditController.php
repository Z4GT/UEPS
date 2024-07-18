<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use OwenIt\Auditing\Models\Audit;
use App\Models\Audit;
use App\Models\User;
use Spatie\Permission\Models\Role;

use Barryvdh\DomPDF\Facade\Pdf as PDF;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::all();
        $users = User::all();
        $roles = Role::all();
        return view('modules.audits.index', compact('audits', 'users', 'roles'));
    }

    public function charts()
    {
        $audits = Audit::all();
        $users = User::all();
        $roles = Role::all();
        return view('modules.audits.charts', compact('audits', 'users', 'roles'));
    }


    public function generatePDF()
    {
        $audits = Audit::all();
        $date = date('d/m/Y H:i:s');

        $data = [
            'title' => 'Registros de Auditoría',
            'date' => $date,
            'audits' => $audits
        ];

        // Configurar el PDF para que sea horizontal (landscape)
        $pdf = PDF::loadView('modules.audits.pdf', $data)->setPaper('a2', 'landscape');
        $pdfName = "Registros Auditoría - {$date}.pdf";

        return $pdf->download($pdfName);
    }
}
