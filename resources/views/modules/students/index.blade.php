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
                                    <h5 class="">Administración de Estudiantes</h5>
                                    <p class="mb-0 text-sm">Aquí puedes gestionar estudiantes.</p>
                                </div>
                                <div class="col-6 text-end">
                                    <button type="button" class="btn btn-dark btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createStudentModal">
                                        <i class="fas fa-user-plus me-2"></i> Agregar estudiante
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
                                            <a class="dropdown-item" href="{{ route('students.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('students.download-excel') }}"
                                                id="xls">Excel</a>
                                        </div>
                                    </div>
                                </div>

                                <label for="table-search" class="tw-sr-only">Search</label>
                                <div class="tw-relative">
                                    <div
                                        class="tw-absolute tw-inset-y-0 tw-rtl:tw-inset-r-0 tw-start-0 tw-flex tw-items-center tw-ps-3 tw-pointer-events-none">
                                        <svg class="tw-w-4 tw-h-4 tw-text-gray-500 dark:tw-text-gray-400"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="table-search-students"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar estudiante..."
                                        onkeyup="searchTable('table-search-students', 'table-students')">
                                </div>
                            </div>
                            <table id="table-students"
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
                                        <th scope="row" class="tw-px-6 tw-py-3">ID</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Cédula</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Nombre</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Apellido</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Curso</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Horas</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Módulos</th>
                                        <th scope="row" class="tw-px-6 tw-py-3">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)
                                        <tr id="student_ids{{ $student->id_stud }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            <td class="tw-w-4 tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input type="checkbox" id="" name="ids"
                                                        class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600"
                                                        value="{{ $student->id_stud }}">
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $student->id_stud }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $student->card_id }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $student->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $student->last_name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $student->course }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $student->hours }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button type="button"
                                                    class="tw-focus:tw-outline-none tw-text-white tw-bg-green-700 hover:tw-bg-green-800 tw-focus:tw-ring-4 tw-focus:tw-ring-green-300 tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-me-2 tw-mb-2 dark:tw-bg-green-600 dark:hover:tw-bg-green-700 dark:tw-focus:tw-ring-green-800"
                                                    data-bs-toggle="modal" data-bs-target="#modulesModal"
                                                    data-student-id="{{ $student->id_stud }}">
                                                    Ver
                                                </button>
                                            </td>

                                            <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                <a href="#"
                                                    class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                    data-bs-toggle="modal" data-bs-target="#editStudentModal"
                                                    data-student-id="{{ $student->id_stud }}"
                                                    data-student-card_id="{{ $student->card_id }}"
                                                    data-student-name="{{ $student->name }}"
                                                    data-student-last_name="{{ $student->last_name }}"
                                                    data-student-course="{{ $student->course }}"
                                                    data-student-hours="{{ $student->hours }}">
                                                    <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" fill="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd"
                                                            d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('students.destroy', $student->id_stud) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                        onclick="return confirm('Estas seguro de quieres eliminar este estudiante?')">
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

    <!-- Modal modules-->
    <div class="modal fade" id="modulesModal" tabindex="-1" aria-labelledby="modulesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modulesModalLabel">Módulos del Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="modulesList" class="list-group">
                        <!-- Los módulos se agregarán aquí -->
                    </ul>
                    <p id="noModulesMessage" class="text-center text-danger mt-3" style="display: none;">El
                        estudiante no está cursando ningún módulo actualmente.</p>
                </div>
            </div>
        </div>
    </div>




    <!-- Create Student Modal -->
    <div class="modal fade" id="createStudentModal" tabindex="-1" aria-labelledby="createStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createStudentModalLabel">Agregar estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createStudentForm" method="POST" action="{{ route('students.store') }}">
                        @csrf
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
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="course" class="form-label">Curso</label>
                            <input type="text" class="form-control" id="course" name="course">
                        </div>
                        <div class="mb-3">
                            <label for="hours" class="form-label">Horas</label>
                            <input type="number" class="form-control" id="hours" name="hours"
                                step="0.01">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Editar Estudiante</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editStudentForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_card_id" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="edit_card_id" name="card_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_last_name" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="edit_last_name" name="last_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_course" class="form-label">Curso</label>
                            <input type="text" class="form-control" id="edit_course" name="course">
                        </div>
                        <div class="mb-3">
                            <label for="edit_hours" class="form-label">Horas</label>
                            <input type="number" class="form-control" id="edit_hours" name="hours"
                                step="0.01">
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
        // Logic to populate and handle the edit student form
        var editStudentModal = document.getElementById('editStudentModal');
        editStudentModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-student-id');
            var studentCardId = button.getAttribute('data-student-card_id');
            var studentName = button.getAttribute('data-student-name');
            var studentLastName = button.getAttribute('data-student-last_name');
            var studentCourse = button.getAttribute('data-student-course');
            var studentHours = button.getAttribute('data-student-hours');

            var modalForm = editStudentModal.querySelector('form');
            modalForm.action = '/info/students/' + studentId;

            var modalCardIdInput = editStudentModal.querySelector('#edit_card_id');
            var modalNameInput = editStudentModal.querySelector('#edit_name');
            var modalLastNameInput = editStudentModal.querySelector('#edit_last_name');
            var modalCourseInput = editStudentModal.querySelector('#edit_course');
            var modalHoursInput = editStudentModal.querySelector('#edit_hours');

            modalCardIdInput.value = studentCardId;
            modalNameInput.value = studentName;
            modalLastNameInput.value = studentLastName;
            modalCourseInput.value = studentCourse;
            modalHoursInput.value = studentHours;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modulesModal = document.getElementById('modulesModal');
        var modulesList = document.getElementById('modulesList');
        var noModulesMessage = document.getElementById('noModulesMessage');

        modulesModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var studentId = button.getAttribute('data-student-id');

            // Realizar una solicitud AJAX para obtener los módulos del estudiante
            fetch(`/info/students/${studentId}/modules`)
                .then(response => response.json())
                .then(data => {
                    modulesList.innerHTML = ''; // Limpiar la lista de módulos
                    if (data.modules.length > 0) {
                        noModulesMessage.style.display = 'none'; // Ocultar el mensaje de error
                        data.modules.forEach(module => {
                            var listItem = document.createElement('li');
                            listItem.className = 'list-group-item';
                            listItem.textContent = module.name;
                            modulesList.appendChild(listItem);
                        });
                    } else {
                        noModulesMessage.style.display = 'block'; // Mostrar el mensaje de error
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    console.log(error);
                    noModulesMessage.textContent = 'Hubo un error al obtener los módulos.';
                    noModulesMessage.style.display = 'block'; // Mostrar el mensaje de error
                });
        });
    });
</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $students->count() }};
        const tableId = 'table-students';
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
            deleteUrl: "{{ route('student.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#student_ids"
        });
    });
</script>
