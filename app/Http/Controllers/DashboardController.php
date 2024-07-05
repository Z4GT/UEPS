<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Project;

class DashboardController extends Controller
{
    public function index()
    {
        $projectCount = Project::count(); // Obtiene el número de proyectos
        return view('dashboard', compact('projectCount'));
    }
}
