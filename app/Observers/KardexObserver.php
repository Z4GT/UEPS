<?php

namespace App\Observers;

use App\Models\Kardex;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

class KardexObserver
{
    /**
     * Handle the Kardex "created" event.
     */
    public function created(Kardex $kardex): void
    {
        //
    }

    // public function creating(Kardex $kardex)
    // {
    //     // Asignar id_pro basado en la ruta actual
    //     $route = Route::current();
    //     if ($route && $route->getName() === 'projects.show') {
    //         $projectId = $route->parameter('id');
    //         if ($projectId) {
    //             $project = Project::find($projectId);
    //             if ($project) {
    //                 $kardex->id_pro = $project->id_pro;
    //             }
    //         }
    //     }
    // }

    /**
     * Handle the Kardex "updated" event.
     */
    public function updated(Kardex $kardex): void
    {
        //
    }

    /**
     * Handle the Kardex "deleted" event.
     */
    public function deleted(Kardex $kardex): void
    {
        //
    }

    /**
     * Handle the Kardex "restored" event.
     */
    public function restored(Kardex $kardex): void
    {
        //
    }

    /**
     * Handle the Kardex "force deleted" event.
     */
    public function forceDeleted(Kardex $kardex): void
    {
        //
    }
}
