<?php
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Student;
?>

<x-app-layout>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="container-fluid py-4 px-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-md-flex align-items-center mb-3 mx-2">
                        <div class="mb-md-0 mb-3">
                            <h3 class="font-weight-bold mb-0">Hola, {{ auth()->user()->name }}</h3>
                            <p class="mb-0">Bienvenido a tu Panel de Control</p>
                        </div>
                        <button type="button"
                            class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                            <span class="btn-inner--icon">
                                <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                    <span class="visually-hidden">New</span>
                                </span>
                            </span>
                            <span class="btn-inner--text">Proyectos</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                            <span class="btn-inner--icon">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                            </span>
                            <span class="btn-inner--text">Refrescar</span>
                        </button>
                    </div>
                </div>
            </div>
            <hr class="my-0">
            <div class="row">
                @if(isset($projects) && count($projects) > 0)
                <div class="position-relative overflow-hidden">
                    <div class="swiper mySwiper mt-4 mb-2">
                        <div class="swiper-wrapper">
                            @foreach ($projects as $project)
                            <div class="swiper-slide">
                                <div>
                                    <div class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                        @php
                                        $imageUrl = $project->image ? asset('storage/' . $project->image) : asset('storage/default.jpg');
                                    @endphp
                                    <div class="full-background bg-cover" style="background-image: url('{{ $imageUrl }}')"></div>
                                        <div class="card-body text-start px-3 py-0 w-100">
                                            <div class="row mt-12">
                                                <div class="col-sm-3 mt-auto">
                                                    <h4 class="text-dark font-weight-bolder" style="color: white !important;">#{{ $loop->iteration }}</h4>
                                                    <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0" style="color: white !important;">Nombre del Proyecto</p>
                                                    <h5 class="text-dark font-weight-bolder" style="color: white !important;">{{ $project->name }}</h5>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
                @else
                <p class="font-weight-bold mb-0">Aún no se ha añadido ningún proyecto</p>
                @endif
                
            </div>
            <div class="row my-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 4.75A2.75 2.75 0 015.75 2h3.086a2.75 2.75 0 012.06.96L11.682 4h6.568A2.75 2.75 0 0121 6.75v10.5A2.75 2.75 0 0118.25 20H5.75A2.75 2.75 0 013 17.25V4.75zM5.75 3.5A1.25 1.25 0 004.5 4.75v12.5c0 .69.56 1.25 1.25 1.25h12.5c.69 0 1.25-.56 1.25-1.25V6.75c0-.69-.56-1.25-1.25-1.25H11a1.25 1.25 0 01-.94-.44L8.75 3.5H5.75z" clip-rule="evenodd"/>
                                </svg>                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Proyectos</p>
                                        <h4 class="mb-2 font-weight-bold">{{Project::count();}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h16a1 1 0 011 1v18a1 1 0 01-1 1H4a1 1 0 01-1-1V3zm2 2h14v14H5V5zm2.293 6.293a1 1 0 011.414 0l1.586 1.586 3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>                                
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Tareas</p>
                                        <h4 class="mb-2 font-weight-bold">{{Task::count();}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 2a5 5 0 100 10 5 5 0 000-10zm-3 5a3 3 0 116 0 3 3 0 01-6 0z" clip-rule="evenodd"/>
                                    <path fill-rule="evenodd" d="M12 12a7 7 0 00-7 7 .75.75 0 001.5 0 5.5 5.5 0 0111 0 .75.75 0 001.5 0 7 7 0 00-7-7z" clip-rule="evenodd"/>
                                </svg>                         
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Usuarios</p>
                                        <h4 class="mb-2 font-weight-bold">{{User::count();}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-body text-start p-3 w-100">
                            <div
                                class="icon icon-shape icon-sm bg-dark text-white text-center border-radius-sm d-flex align-items-center justify-content-center mb-3">
                                <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 2L1 7l11 5 11-5-11-5zm0 2.236L18.764 7 12 9.764 5.236 7 12 4.236zM4.5 9.5l-2.236 1.118L12 16.5l9.736-5.882L19.5 9.5l-7.5 3.882L4.5 9.5zM12 18l-8.5 4v-3.5l8.5-3.5 8.5 3.5V22L12 18z" clip-rule="evenodd"/>
                                </svg>                                                           
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="w-100">
                                        <p class="text-sm text-secondary mb-1">Estudiantes</p>
                                        <h4 class="mb-2 font-weight-bold">{{Student::count();}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row my-2">
                
                <div class="col-lg-4 col-md-6 mb-md-0 mb-4">
                    <div class="card shadow-xs border h-100">
                        <div class="card-header pb-0">
                            <h6 class="font-weight-semibold text-lg mb-0">Avance Por Proyecto</h6>
                            <p class="text-sm">Aquí tienes detalles sobre los avances de cada proyecto.</p>
                            {{-- <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio1"
                                    autocomplete="off" checked>
                                <label class="btn btn-white px-3 mb-0" for="btnradio1">12 meses</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio2"
                                    autocomplete="off">
                                <label class="btn btn-white px-3 mb-0" for="btnradio2">30 días</label>
                                <input type="radio" class="btn-check" name="btnradio" id="btnradio3"
                                    autocomplete="off">
                                <label class="btn btn-white px-3 mb-0" for="btnradio3">7 días</label>
                            </div> --}}
                        </div>
                        <div class="card-body py-3">
                            <div class="chart mb-2">
                                <div style="width: 80%; margin: auto;">
                                    <canvas id="projectProgressChart"></canvas>
                                </div>
                            
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        var ctx = document.getElementById('projectProgressChart').getContext('2d');
                                        var projectNames = @json($projects->pluck('name')).slice(0, 5);
                                        var projectProgress = @json($projects->pluck('progress')).slice(0, 5);
                                    
                                        var chart = new Chart(ctx, {
                                            type: 'bar', // Puedes cambiar el tipo de gráfico aquí
                                            data: {
                                                labels: projectNames,
                                                datasets: [{
                                                    label: 'Progreso de Proyectos (%)',
                                                    data: projectProgress,
                                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                                    borderColor: 'rgba(75, 192, 192, 1)',
                                                    borderWidth: 1
                                                }]
                                            },
                                            options: {
                                                scales: {
                                                    y: {
                                                        beginAtZero: true,
                                                        max: 100
                                                    }
                                                }
                                            }
                                        });
                                    });
                                    </script>
                                                               </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-6">
                    <div class="card shadow-xs border">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center mb-3">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Tareas Recientes</h6>
                                    <p class="text-sm mb-sm-0 mb-2">Estas son las tareas recientes</p>
                                </div>
                                
                            </div>
                           
                        </div>
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center justify-content-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">
                                                Tarea</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Avance</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Fecha
                                            </th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">
                                                Proyecto</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2">
                                                        <div class="my-auto">
                                                            <h6 class="mb-0 text-sm">{{ $task->name }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-sm font-weight-normal mb-0">{{ $task->percentage }}</p>
                                                </td>
                                                <td>
                                                    <span class="text-sm font-weight-normal">{{ $task->end_date }}</span>
                                                </td>
                                                <td class="align-middle">
                                                    <div class="ms-2">
                                                        <p class="text-dark text-sm mb-0">{{ $task->project->name }}</p>
                                                    </div>
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
    </main>

    <script src="{{ asset('js/breadcrumbs.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</x-app-layout>
