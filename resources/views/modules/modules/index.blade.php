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
                                    <h5 class="">Administración de Módulos</h5>
                                    <p class="mb-0 text-sm">Aquí puedes gestionar los módulos.</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn btn-dark btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createModuleModal">
                                        <i class="fas fa-plus me-2"></i> Agregar módulo
                                    </button>
                                </div>
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
                                    <div class="dropdown mr-3">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Acción
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#" id="deleteSelected">Eliminar</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Generar
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                            <a class="dropdown-item" href="{{ route('modules.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('modules.download-excel') }}"
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
                                    <input type="text" id="table-search-modules"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar módulo..."
                                        onkeyup="searchTable('table-search-modules', 'table-modules')">
                                </div>
                            </div>
                            <table id="table-modules"
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
                                        <th scope="col" class="tw-px-6 tw-py-3">Responsable</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Fecha de Inicio</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Fecha de Fin</th>
                                        <th scope="col" class="tw-px-6 tw-py-3 tw-w-2">Horas de Vinculación</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Estudiantes</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modules as $module)
                                        <tr id="modules_ids{{ $module->id_mod }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            <td class="tw-w-4 tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input type="checkbox" value="{{ $module->id_mod }}"
                                                        class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->id_mod }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->responsible->name }}
                                                {{ $module->responsible->last_name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->start_date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->end_date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $module->vinculation_hours }}</td>
                                            <td class="tw-px-6 tw-py-4" style="width: 150px;">
                                                <button type="button"
                                                    class="tw-w-full tw-text-white tw-bg-green-700 hover:tw-bg-green-800 focus:tw-ring-4 focus:tw-ring-green-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-2 tw-py-1 dark:tw-bg-green-600 dark:hover:tw-bg-green-700 dark:tw-focus:tw-ring-green-800"
                                                    data-bs-toggle="modal" data-bs-target="#studentsModal"
                                                    data-module-id="{{ $module->id_mod }}">
                                                    Ver
                                                </button>
                                            </td>
                                            <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                <a href="#"
                                                    class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                    data-bs-toggle="modal" data-bs-target="#editModuleModal"
                                                    data-module-id="{{ $module->id_mod }}"
                                                    data-module-name="{{ $module->name }}"
                                                    data-module-responsible="{{ $module->id_responsible }}"
                                                    data-module-start_date="{{ $module->start_date }}"
                                                    data-module-end_date="{{ $module->end_date }}"
                                                    data-module-vinculation_hours="{{ $module->vinculation_hours }}">
                                                    <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('modules.destroy', $module->id_mod) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este módulo?')">
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

    <!-- Modal para mostrar estudiantes -->
    <div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentsModalLabel">Estudiantes en el Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="studentsList" class="tw-list-disc tw-ml-4">
                        <!-- Los estudiantes se cargarán aquí -->
                    </ul>
                    <div id="noStudentsMessage" class="tw-hidden tw-text-red-600">
                        Este módulo no tiene estudiantes actualmente.
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Create Module Modal -->
    <div class="modal fade" id="createModuleModal" tabindex="-1" aria-labelledby="createModuleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModuleModalLabel">Agregar módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createModuleForm" method="POST" action="{{ route('modules.store') }}">
                        @csrf
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_responsible" class="form-label">Responsable</label>
                                <select class="form-control" id="id_responsible" name="id_responsible" required>
                                    @foreach ($responsibles as $responsible)
                                        <option value="{{ $responsible->id_responsible }}">{{ $responsible->name }}
                                            {{ $responsible->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createResponsibleModal" data-bs-dismiss="modal">Agregar
                                    Responsable</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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
                            <label for="vinculation_hours" class="form-label">Horas de Vinculación</label>
                            <input type="number" class="form-control" id="vinculation_hours"
                                name="vinculation_hours" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Module Modal -->
    <div class="modal fade" id="editModuleModal" tabindex="-1" aria-labelledby="editModuleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModuleModalLabel">Editar Módulo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editModuleForm" method="POST" action="">
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
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createResponsibleModal" data-bs-dismiss="modal">Agregar
                                    Responsable</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
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
                            <label for="edit_vinculation_hours" class="form-label">Horas de Vinculación</label>
                            <input type="number" class="form-control" id="edit_vinculation_hours"
                                name="vinculation_hours" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal Responsable --}}
    <div class="modal fade" id="createResponsibleModal" tabindex="-1" aria-labelledby="createResponsibleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createResponsibleModalLabel">Agregar responsable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createResponsibleForm" method="POST" action="{{ route('responsibles.store') }}">
                        @csrf
                        <input type="hidden" name="from_module" value="true">
                        <div class="mb-3">
                            <label for="card_id" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="card_id" name="card_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">Área</label>
                            <input type="text" class="form-control" id="area" name="area" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Rol</label>
                            <input type="text" class="form-control" id="role" name="role" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Estado</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logic to populate and handle the edit module form
        var editModuleModal = document.getElementById('editModuleModal');
        editModuleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var moduleId = button.getAttribute('data-module-id');
            var moduleName = button.getAttribute('data-module-name');
            var moduleResponsible = button.getAttribute('data-module-responsible');
            var moduleStartDate = button.getAttribute('data-module-start_date');
            var moduleEndDate = button.getAttribute('data-module-end_date');
            var moduleVinculationHours = button.getAttribute('data-module-vinculation_hours');

            var modalForm = editModuleModal.querySelector('form');
            modalForm.action = '/info/modules/' + moduleId;

            var modalNameInput = editModuleModal.querySelector('#edit_name');
            var modalResponsibleInput = editModuleModal.querySelector('#edit_id_responsible');
            var modalStartDateInput = editModuleModal.querySelector('#edit_start_date');
            var modalEndDateInput = editModuleModal.querySelector('#edit_end_date');
            var modalVinculationHoursInput = editModuleModal.querySelector('#edit_vinculation_hours');

            modalNameInput.value = moduleName;
            modalResponsibleInput.value = moduleResponsible;
            modalStartDateInput.value = moduleStartDate;
            modalEndDateInput.value = moduleEndDate;
            modalVinculationHoursInput.value = moduleVinculationHours;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var studentsModal = document.getElementById('studentsModal');
        studentsModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var moduleId = button.getAttribute('data-module-id');


            fetch(`/modules/${moduleId}/students`)
                .then(response => response.json())
                .then(data => {
                    var studentsList = document.getElementById('studentsList');
                    var noStudentsMessage = document.getElementById('noStudentsMessage');

                    studentsList.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(student => {
                            var listItem = document.createElement('li');
                            listItem.textContent = student.name + ' ' + student.last_name;
                            studentsList.appendChild(listItem);
                        });
                        studentsList.classList.remove('tw-hidden');
                        noStudentsMessage.classList.add('tw-hidden');
                    } else {
                        studentsList.classList.add('tw-hidden');
                        noStudentsMessage.classList.remove('tw-hidden');
                    }
                })
                .catch(error => console.error('Error al obtener los estudiantes:', error));
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $modules->count() }};
        const tableId = 'table-modules';
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
            deleteUrl: "{{ route('module.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#modules_ids"
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Almacenar el modal de módulo activo (agregar o editar)
        var activeModuleModal = null;

        // Abrir modal de agregar responsable desde modal de agregar o editar módulo
        document.querySelectorAll('[data-bs-target="#createResponsibleModal"]').forEach(function(button) {
            button.addEventListener('click', function(event) {
                var parentModal = event.target.closest('.modal');
                if (parentModal) {
                    activeModuleModal = parentModal.getAttribute('id');
                }
            });
        });

        // Volver al modal de módulo activo después de cerrar el modal de agregar responsable
        document.getElementById('createResponsibleModal').addEventListener('hidden.bs.modal', function() {
            if (activeModuleModal) {
                var moduleModal = document.getElementById(activeModuleModal);
                var bootstrapModal = bootstrap.Modal.getInstance(moduleModal);
                bootstrapModal.show();
                activeModuleModal = null;
            }
        });
    });
</script>
