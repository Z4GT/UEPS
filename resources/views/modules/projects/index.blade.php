<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">

                        <div class="pb-2 card-header">
                            <div class="row">
                                <div class="col-6">
                                    @role('rector')
                                        <h5 class="">Administración de Proyectos</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los proyectos.</p>
                                    @else
                                        <h5 class="">Proyectos</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los proyectos.</p>
                                    @endrole
                                </div>
                                @role('rector')
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#createProjectModal">
                                            <i class="fas fa-plus me-2"></i> Agregar proyecto
                                        </button>
                                    </div>
                                @endrole
                            </div>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Mensaje de éxito -->
                        <div id="message"
                            class="tw-hidden tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Éxito!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text"></span>
                        </div>

                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-pb-4 tw-bg-white dark:tw-bg-gray-900">
                                <div class="d-flex flex-row justify-content-start">
                                    @role('rector')
                                        <div class="dropdown mr-3">
                                            <button class="btn btn-info dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Acción
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#" id="deleteSelected">Eliminar</a>
                                            </div>
                                        </div>
                                    @endrole
                                    <div class="dropdown mr-2">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Generar
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="{{ route('projects.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('projects.download-excel') }}"
                                                id="xls">Excel</a>
                                        </div>
                                    </div>
                                </div>

                                <label for="table-search" class="tw-sr-only">Buscar</label>
                                <div class="tw-relative">
                                    <div
                                        class="tw-absolute tw-inset-y-0 tw-start-0 tw-flex tw-items-center tw-ps-3 tw-pointer-events-none">
                                        <svg class="tw-w-4 tw-h-4 tw-text-gray-500 dark:tw-text-gray-400"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="table-search-projects"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar proyecto..."
                                        onkeyup="searchTable('table-search-projects','table-projects')">
                                </div>
                            </div>
                            <table id="table-projects"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        @role('rector')
                                            <th scope="col" class="tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input id="select_all_ids" type="checkbox"
                                                        class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                </div>
                                            </th>
                                        @endrole
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                ID
                                                <a
                                                    href="?sort=id_pro&direction={{ $sortField === 'id_pro' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Nombre
                                                <a
                                                    href="?sort=name&direction={{ $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Responsable
                                                <a
                                                    href="?sort=id_responsible&direction={{ $sortField === 'id_responsible' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Descripción</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Estado
                                                <a
                                                    href="?sort=status&direction={{ $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Progreso
                                                <a
                                                    href="?sort=progress&direction={{ $sortField === 'progress' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Fecha de Inicio
                                                <a
                                                    href="?sort=start_date&direction={{ $sortField === 'start_date' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Fecha de Fin
                                                <a
                                                    href="?sort=end_date&direction={{ $sortField === 'end_date' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Presupuesto
                                                <a
                                                    href="?sort=budget&direction={{ $sortField === 'budget' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Módulos</th>
                                        @role('rector')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($projects as $project)
                                        <tr id="project_ids{{ $project->id_pro }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('rector')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $project->id_pro }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">{{ $project->id_pro }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $project->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $project->responsible->name }}
                                                {{ $project->responsible->last_name }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="toggle-description tw-text-blue-600 hover:tw-underline"
                                                    data-project-id="{{ $project->id_pro }}">
                                                    <img src="{{ asset('assets/img/logos/plus.svg') }}"
                                                        class="tw-w-5 tw-h-5">
                                                </button>
                                                <div class="description-content tw-hidden tw-mt-2">
                                                    {{ $project->description }}
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $project->status }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <div
                                                    class="tw-mb-1 tw-text-base tw-font-medium tw-text-gray-700 dark:tw-text-gray-400">
                                                    {{ $project->progress }}%
                                                </div>
                                                <div
                                                    class="tw-w-full tw-bg-gray-200 tw-rounded-full tw-h-2.5 dark:tw-bg-gray-700">
                                                    <div class="tw-bg-blue-600 tw-h-2.5 tw-rounded-full"
                                                        style="width: {{ $project->progress }}%"></div>
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $project->start_date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $project->end_date }}</td>
                                            <td class="tw-px-6 tw-py-4">${{ number_format($project->budget, 2) }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="btn btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#modulesModal{{ $project->id_pro }}">
                                                    Ver
                                                </button>
                                                <!-- Modal -->
                                                <div class="modal fade" id="modulesModal{{ $project->id_pro }}"
                                                    tabindex="-1"
                                                    aria-labelledby="modulesModalLabel{{ $project->id_pro }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"
                                                                    id="modulesModalLabel{{ $project->id_pro }}">
                                                                    Módulos de {{ $project->name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul class="list-group">
                                                                    @foreach ($project->modules as $module)
                                                                        <li class="list-group-item">
                                                                            {{ $module->name }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            @role('rector')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editProjectModal"
                                                        data-project-id="{{ $project->id_pro }}"
                                                        data-project-name="{{ $project->name }}"
                                                        data-project-responsible="{{ $project->id_responsible }}"
                                                        data-project-description="{{ $project->description }}"
                                                        data-project-status="{{ $project->status }}"
                                                        data-project-progress="{{ $project->progress }}"
                                                        data-project-start_date="{{ $project->start_date }}"
                                                        data-project-end_date="{{ $project->end_date }}"
                                                        data-project-budget="{{ $project->budget }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('projects.destroy', $project->id_pro) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este proyecto?')">
                                                            <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path fill-rule="evenodd"
                                                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-px-4 tw-py-3 tw-bg-white tw-border-t tw-border-gray-200 sm:tw-px-6">
                                <div class="tw-flex tw-items-center">
                                    <span class="tw-text-sm tw-text-gray-700 tw-mr-2">Mostrar</span>
                                    <select id="records-per-page"
                                        class="tw-form-select tw-rounded-md tw-shadow-sm tw-text-sm tw-font-medium tw-text-gray-700 tw-bg-white hover:tw-bg-gray-50 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-offset-2 focus:tw-ring-offset-gray-100 focus:tw-ring-indigo-500">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                    </select>
                                    <span class="tw-text-sm tw-text-gray-700 tw-ml-2">registros</span>
                                </div>
                                <div class="tw-flex tw-items-center">
                                    <span class="tw-text-sm tw-text-gray-700 tw-mr-2">Página</span>
                                    <div id="pagination-numbers" class="tw-flex tw-space-x-2">
                                        <!-- Los números de página se renderizarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Create Project Modal -->
    <div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProjectModalLabel">Agregar proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createProjectForm" method="POST" action="{{ route('projects.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_responsible" class="form-label">Responsable</label>
                                <select class="form-control" id="id_responsible" name="id_responsible" required>
                                    @foreach ($responsibles as $responsible)
                                        <option value="{{ $responsible->id_responsible }}">{{ $responsible->name }}
                                            {{ $responsible->last_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('responsibles.index') }}" class="btn btn-info">Agregar
                                    Responsable</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="modules" class="form-label">Módulos:</label>
                            @foreach ($modules as $module)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $module->id_mod }}"
                                        id="module{{ $module->id_mod }}" name="modules[]">
                                    <label class="form-check-label" for="module{{ $module->id_mod }}">
                                        {{ $module->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="initiated">Iniciado</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="cancelled">Cancelado</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="progress" class="form-label">Progreso (%)</label>
                            <input type="number" class="form-control" id="progress" name="progress"
                                min="0" max="100" step="any" required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="budget" class="form-label">Presupuesto</label>
                            <input type="number" class="form-control" id="budget" name="budget" step="any"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Fotografia</label>
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div class="modal fade" id="editProjectModal" tabindex="-1" aria-labelledby="editProjectModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProjectModalLabel">Editar Proyecto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editProjectForm" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="edit_id_responsible" class="form-label">Responsable</label>
                                <select class="form-control" id="edit_id_responsible" name="id_responsible" required>
                                    @foreach ($responsibles as $responsible)
                                        <option value="{{ $responsible->id_responsible }}">
                                            {{ $responsible->name }} {{ $responsible->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('responsibles.index') }}" class="btn btn-info">Agregar
                                    Responsable</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="edit_description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_modules" class="form-label">Módulos:</label>
                            @foreach ($modules as $module)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $module->id_mod }}"
                                        id="edit_module{{ $module->id_mod }}" name="modules[]">
                                    <label class="form-check-label" for="edit_module{{ $module->id_mod }}">
                                        {{ $module->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Estado:</label>
                            <select class="form-control" id="edit_status" name="status">
                                <option value="initiated">Iniciado</option>
                                <option value="in_progress">En Progreso</option>
                                <option value="cancelled">Cancelado</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_progress" class="form-label">Progreso (%)</label>
                            <input type="number" class="form-control" id="edit_progress" name="progress"
                                min="0" max="100" step="any" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">Fecha de Fin</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_budget" class="form-label">Presupuesto</label>
                            <input type="number" class="form-control" id="edit_budget" name="budget"
                                step="any" required>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Fotografia</label>
                            <input type="file" class="form-control" id="edit_image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logic to populate and handle the edit project form
        var editProjectModal = document.getElementById('editProjectModal');
        editProjectModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var projectId = button.getAttribute('data-project-id');
            var projectName = button.getAttribute('data-project-name');
            var projectResponsible = button.getAttribute('data-project-responsible');
            var projectDescription = button.getAttribute('data-project-description');
            var projectStatus = button.getAttribute('data-project-status');
            var projectProgress = button.getAttribute('data-project-progress');
            var projectStartDate = button.getAttribute('data-project-start_date');
            var projectEndDate = button.getAttribute('data-project-end_date');
            var projectBudget = button.getAttribute('data-project-budget');

            var modalForm = editProjectModal.querySelector('form');
            modalForm.action = '/info/projects/' + projectId;

            var modalNameInput = editProjectModal.querySelector('#edit_name');
            var modalResponsibleInput = editProjectModal.querySelector('#edit_id_responsible');
            var modalDescriptionInput = editProjectModal.querySelector('#edit_description');
            var modalStatusInput = editProjectModal.querySelector('#edit_status');
            var modalProgressInput = editProjectModal.querySelector('#edit_progress');
            var modalStartDateInput = editProjectModal.querySelector('#edit_start_date');
            var modalEndDateInput = editProjectModal.querySelector('#edit_end_date');
            var modalBudgetInput = editProjectModal.querySelector('#edit_budget');

            modalNameInput.value = projectName;
            modalResponsibleInput.value = projectResponsible;
            modalDescriptionInput.value = projectDescription;
            modalStatusInput.value = projectStatus;
            modalProgressInput.value = projectProgress;
            modalStartDateInput.value = projectStartDate;
            modalEndDateInput.value = projectEndDate;
            modalBudgetInput.value = projectBudget;
        });

        // Toggle description visibility
        document.querySelectorAll('.toggle-description').forEach(button => {
            button.addEventListener('click', function() {
                const descriptionContent = this.nextElementSibling;
                if (descriptionContent.classList.contains('tw-hidden')) {
                    descriptionContent.classList.remove('tw-hidden');
                    this.querySelector('img').src =
                        '{{ asset('assets/img/logos/minus.svg') }}';
                } else {
                    descriptionContent.classList.add('tw-hidden');
                    this.querySelector('img').src = '{{ asset('assets/img/logos/plus.svg') }}';
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $projects->count() }};
        const tableId = 'table-projects';
        const paginationContainerId = 'pagination-numbers';
        const defaultRecordsPerPage = 10;

        initPagination(totalRecords, tableId, paginationContainerId, defaultRecordsPerPage);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        initializeDeleteAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deleteButtonId: "#deleteSelected",
            deleteUrl: "{{ route('project.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#project_ids"
        });
    });
</script>
