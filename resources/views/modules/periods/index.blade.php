<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="pb-1 card-header">
                            <div class="row">
                                <div class="col-6">
                                    @role('administrador')
                                        <h5 class="">Administración de Periodos</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los periodos.</p>
                                    @else
                                        <h5 class=""> Periodos</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los periodos.</p>
                                    @endrole
                                </div>
                                @role('administrador')
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-success btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createPeriodModal">
                                            <i class="fas fa-plus me-2"></i> Agregar periodo
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
                                class="tw-flex tw-items-center tw-justify-between tw-flex-column tw-flex-wrap md:tw-flex-row tw-space-y-4 md:tw-space-y-0 tw-pb-4 tw-bg-white dark:tw-bg-gray-900">


                                <div class="d-flex flex-row justify-content-start">
                                    @role('administrador')
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
                                            <a class="dropdown-item" href="{{ route('periods.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('periods.download-excel') }}"
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
                                    <input type="text" id="table-search-periods"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar periodo..."
                                        onkeyup="searchTable('table-search-periods', 'table-periods')">
                                </div>
                            </div>
                            <table id="table-periods"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        @role('administrador')
                                            <th scope="col" class="tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input id="select_all_ids" type="checkbox"
                                                        class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                </div>
                                            </th>
                                        @endrole
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            Nombre
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            Año Académico
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            Fecha de Inicio
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            Fecha de Finalización
                                        </th>
                                        @role('administrador')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($periods as $period)
                                        <tr id="period_ids{{ $period->id_period }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('administrador')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $period->id_period }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $period->name }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $period->academic_year }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $period->start_date }}
                                            </td>
                                            <td class="tw-px-6 tw-py-4">
                                                {{ $period->end_date }}
                                            </td>
                                            @role('administrador')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editPeriodModal"
                                                        data-period-id="{{ $period->id_period }}"
                                                        data-period-name="{{ $period->name }}"
                                                        data-period-academic_year="{{ $period->academic_year }}"
                                                        data-period-start_date="{{ $period->start_date }}"
                                                        data-period-end_date="{{ $period->end_date }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('periods.destroy', $period->id_period) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Está seguro de que desea eliminar este periodo?')">
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

    <!-- Create Period Modal -->
    <div class="modal fade" id="createPeriodModal" tabindex="-1" aria-labelledby="createPeriodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createPeriodModalLabel">Agregar periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createPeriodForm" method="POST" action="{{ route('periods.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="academic_year" class="form-label">Año Académico</label>
                            <input type="number" class="form-control" id="academic_year" name="academic_year"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Finalización</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Period Modal -->
    <div class="modal fade" id="editPeriodModal" tabindex="-1" aria-labelledby="editPeriodModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPeriodModalLabel">Editar Periodo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editPeriodForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_academic_year" class="form-label">Año Académico</label>
                            <input type="number" class="form-control" id="edit_academic_year" name="academic_year"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_start_date" class="form-label">Fecha de Inicio</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_end_date" class="form-label">Fecha de Finalización</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
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
        // Logic to populate and handle the edit period form
        var editPeriodModal = document.getElementById('editPeriodModal');
        editPeriodModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var periodId = button.getAttribute('data-period-id');
            var periodName = button.getAttribute('data-period-name');
            var periodAcademicYear = button.getAttribute('data-period-academic_year');
            var periodStartDate = button.getAttribute('data-period-start_date');
            var periodEndDate = button.getAttribute('data-period-end_date');

            var modalForm = editPeriodModal.querySelector('form');
            modalForm.action = '/info/periods/' + periodId;

            var modalNameInput = editPeriodModal.querySelector('#edit_name');
            var modalAcademicYearInput = editPeriodModal.querySelector('#edit_academic_year');
            var modalStartDateInput = editPeriodModal.querySelector('#edit_start_date');
            var modalEndDateInput = editPeriodModal.querySelector('#edit_end_date');

            modalNameInput.value = periodName;
            modalAcademicYearInput.value = periodAcademicYear;
            modalStartDateInput.value = periodStartDate;
            modalEndDateInput.value = periodEndDate;
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $periods->count() }};
        const tableId = 'table-periods';
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
            deleteUrl: "{{ route('period.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#period_ids"
        });
    });
</script>
