<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use OwenIt\Auditing\Models\Audit;
use App\Models\Audit;

class AuditController extends Controller
{
    public function index()
    {
        $audits = Audit::all();
        return view('modules.audits.index', compact('audits'));
    }
}
