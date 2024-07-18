<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="pb-0 card-header">
                            <div class="row">
                                <div class="col-6">
                                    @role('rector|jefe de proyecto')
                                        <h5 class="">Administración de Tareas</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar las tareas.</p>
                                    @else
                                        <h5 class="">Tareas</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar las tareas.</p>
                                    @endrole
                                </div>
                                @role('rector|jefe de proyecto')
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#createTaskModal">
                                            <i class="fas fa-plus me-2"></i> Agregar tarea
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
                            class="tw-hidden tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-mt-2 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Éxito!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text"></span>
                        </div>
                        <!-- Mensaje de error -->
                        <div id="message-error"
                            class="tw-hidden tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-mt-2 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Error!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text-error"></span>
                        </div>

                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-pb-4 tw-bg-white dark:tw-bg-gray-900">
                                <div class="d-flex flex-row justify-content-start">
                                    @role('rector|jefe de proyecto')
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
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Generar
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="{{ route('tasks.pdf') }}"
                                                id="pdf">PDF</a>
                                            <a class="dropdown-item" href="{{ route('tasks.download-excel') }}"
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
                                    <input type="text" id="table-search-tasks"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar tarea..."
                                        onkeyup="searchTable('table-search-tasks', 'table-tasks')">
                                </div>
                            </div>
                            <table id="table-tasks"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        <th scope="col" class="tw-p-4">
                                            <div class="tw-flex tw-items-center">
                                                <input id="select_all_ids" type="checkbox"
                                                    class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">ID</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Nombre</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Proyecto</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Descripción</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Horas</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Fecha de Inicio</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Fecha de Fin</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Porcentaje</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Estado</th>
                                        @role('rector|jefe de proyecto')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tasks as $task)
                                        <tr id="task_ids{{ $task->id_task }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('rector|jefe de proyecto')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $task->id_task }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">{{ $task->id_task }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->project->name }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="toggle-description tw-text-blue-600 hover:tw-underline"
                                                    data-task-id="{{ $task->id_pro }}">
                                                    <img src="{{ asset('assets/img/logos/plus.svg') }}"
                                                        class="tw-w-5 tw-h-5">
                                                </button>
                                                <div class="description-content tw-hidden tw-mt-2">
                                                    {{ $task->description }}
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->hours }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->start_date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->end_date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->percentage }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $task->status }} </td>
                                            @role('rector|jefe de proyecto')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editTaskModal"
                                                        data-task-id="{{ $task->id_task }}"
                                                        data-task-name="{{ $task->name }}"
                                                        data-task-project="{{ $task->id_pro }}"
                                                        data-task-description="{{ $task->description }}"
                                                        data-task-hours="{{ $task->hours }}"
                                                        data-task-start_date="{{ $task->start_date }}"
                                                        data-task-end_date="{{ $task->end_date }}"
                                                        data-task-percentage="{{ $task->percentage }}"
                                                        data-task-status="{{ $task->status }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('tasks.destroy', $task->id_task) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta tarea?')">
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
        <x-app.footer />
    </main>

    <!-- Create Task Modal -->
    <div class="modal fade" id="createTaskModal" tabindex="-1" aria-labelledby="createTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createTaskModalLabel">Agregar tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createTaskForm" method="POST" action="{{ route('tasks.store') }}">
                        @csrf
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_pro" class="form-label">Proyecto</label>
                                <select class="form-control" id="id_pro" name="id_pro" required>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id_pro }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('projects.index') }}" class="btn btn-info">Agregar Proyecto</a>
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
                            <label for="hours" class="form-label">Horas</label>
                            <input type="number" class="form-control" id="hours" name="hours" step="any"
                                required>
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
                            <label for="percentage" class="form-label">Porcentaje</label>
                            <input type="number" class="form-control" id="percentage" name="percentage" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado:</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completado</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTaskModalLabel">Editar Tarea</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editTaskForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="edit_id_pro" class="form-label">Proyecto</label>
                                <select class="form-control" id="edit_id_pro" name="id_pro" required>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id_pro }}">
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('projects.index') }}" class="btn btn-info">Agregar Proyecto</a>
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
                            <label for="edit_hours" class="form-label">Horas</label>
                            <input type="number" class="form-control" id="edit_hours" name="hours"
                                step="any"" required>
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
                            <label for="edit_percentage" class="form-label">Porcentaje</label>
                            <input type="number" class="form-control" id="edit_percentage" name="percentage"
                                step="any" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Estado:</label>
                            <select class="form-control" id="edit_status" name="status">
                                <option value="pending">Pendiente</option>
                                <option value="completed">Completado</option>
                            </select>

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
        // Logic to populate and handle the edit task form
        var editTaskModal = document.getElementById('editTaskModal');
        editTaskModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var taskId = button.getAttribute('data-task-id');
            var taskName = button.getAttribute('data-task-name');
            var taskProject = button.getAttribute('data-task-project');
            var taskDescription = button.getAttribute('data-task-description');
            var taskHours = button.getAttribute('data-task-hours');
            var taskStartDate = button.getAttribute('data-task-start_date');
            var taskEndDate = button.getAttribute('data-task-end_date');
            var taskPercentage = button.getAttribute('data-task-percentage');
            var taskStatus = button.getAttribute('data-task-status');

            var modalForm = editTaskModal.querySelector('form');
            modalForm.action = '/info/tasks/' + taskId;

            var modalNameInput = editTaskModal.querySelector('#edit_name');
            var modalProjectInput = editTaskModal.querySelector('#edit_id_pro');
            var modalDescriptionInput = editTaskModal.querySelector('#edit_description');
            var modalHoursInput = editTaskModal.querySelector('#edit_hours');
            var modalStartDateInput = editTaskModal.querySelector('#edit_start_date');
            var modalEndDateInput = editTaskModal.querySelector('#edit_end_date');
            var modalPercentageInput = editTaskModal.querySelector('#edit_percentage');
            var modalStatusInput = editTaskModal.querySelector('#edit_status');

            modalNameInput.value = taskName;
            modalProjectInput.value = taskProject;
            modalDescriptionInput.value = taskDescription;
            modalHoursInput.value = taskHours;
            modalStartDateInput.value = taskStartDate;
            modalEndDateInput.value = taskEndDate;
            modalPercentageInput.value = taskPercentage;
            modalStatusInput.value = taskStatus;
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
        const totalRecords = {{ $tasks->count() }};
        const tableId = 'table-tasks';
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
            deleteUrl: "{{ route('task.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#task_ids"
        });
    });
</script>
