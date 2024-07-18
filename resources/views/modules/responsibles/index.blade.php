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
                                    @role('administrador')
                                        <h5 class="">Administración de responsables</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los responsables.</p>
                                    @else
                                        <h5 class="">Responsables</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los responsables.</p>
                                    @endrole
                                </div>
                                @role('administrador')
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-success btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createResponsibleModal">
                                            <i class="fas fa-user-plus me-2"></i> Agregar responsable
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
                                    @role('administrador')
                                        <div class="dropdown mr-3">
                                            <button class="btn btn-info dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Acción
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="#"
                                                    id="deactivateSelected">Desactivar</a>
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
                                            <a class="dropdown-item" href="{{ route('responsibles.pdf') }}"
                                                id="excel">PDF</a>
                                            <a class="dropdown-item" href="{{ route('responsibles.download-excel') }}"
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
                                    <input type="text" id="table-search-responsibles"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:tw-focus:tw-ring-blue-500 dark:tw-focus:tw-border-blue-500"
                                        placeholder="Buscar responsable..."
                                        onkeyup="searchTable('table-search-responsibles', 'table-responsibles')">
                                </div>
                            </div>
                            <table id="table-responsibles"
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
                                            <div class="tw-flex tw-items-center">
                                                ID
                                                <a
                                                    href="?sort=id_responsible&direction={{ $sortField === 'id_responsible' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Cédula
                                                <a
                                                    href="?sort=card_id&direction={{ $sortField === 'card_id' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Nombre
                                                <a
                                                    href="?sort=name&direction={{ $sortField === 'name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Apellido
                                                <a
                                                    href="?sort=last_name&direction={{ $sortField === 'last_name' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Área
                                                <a
                                                    href="?sort=area&direction={{ $sortField === 'area' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Rol
                                                <a
                                                    href="?sort=role&direction={{ $sortField === 'role' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Estado
                                                <a
                                                    href="?sort=status&direction={{ $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-5 tw-h-5 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}"
                                                        viewBox="0 0 24 24">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">ID Usuario</th>
                                        @role('administrador')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($responsibles as $responsible)
                                        <tr id="responsible_ids{{ $responsible->id_responsible }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('administrador')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $responsible->id_responsible }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:tw-focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">

                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->id_responsible }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->card_id }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->last_name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->area }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->role }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <div class="tw-flex tw-items-center">
                                                    <div
                                                        class="tw-h-2.5 tw-w-2.5 tw-rounded-full {{ $responsible->status ? 'tw-bg-green-500' : 'tw-bg-red-500' }} tw-me-2">
                                                    </div> {{ $responsible->status ? 'Activo' : 'Inactivo' }}
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $responsible->id_user }}</td>
                                            @role('administrador')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editResponsibleModal"
                                                        data-responsible-id="{{ $responsible->id_responsible }}"
                                                        data-responsible-card_id="{{ $responsible->card_id }}"
                                                        data-responsible-name="{{ $responsible->name }}"
                                                        data-responsible-last_name="{{ $responsible->last_name }}"
                                                        data-responsible-area="{{ $responsible->area }}"
                                                        data-responsible-role="{{ $responsible->role }}"
                                                        data-responsible-status="{{ $responsible->status }}"
                                                        data-responsible-id_user="{{ $responsible->id_user }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form
                                                        action="{{ route('responsibles.destroy', $responsible->id_responsible) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este responsable?')">
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

    <!-- Create Responsible Modal -->
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
                            <label for="id_user" class="form-label">Usuario (opcional)</label>
                            <select class="form-control" id="id_user" name="id_user">
                                <option value="">Seleccionar usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->id }} .- {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
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

    <!-- Edit Responsible Modal -->
    <div class="modal fade" id="editResponsibleModal" tabindex="-1" aria-labelledby="editResponsibleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editResponsibleModalLabel">Editar Responsable</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editResponsibleForm" method="POST" action="">
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
                            <input type="text" class="form-control" id="edit_last_name" name="last_name"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_area" class="form-label">Área</label>
                            <input type="text" class="form-control" id="edit_area" name="area" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role" class="form-label">Rol</label>
                            <input type="text" class="form-control" id="edit_role" name="role" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_status" class="form-label">Estado</label>
                            <select class="form-control" id="edit_status" name="status" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_user" class="form-label">Usuario (opcional)</label>
                            <select class="form-control" id="edit_id_user" name="id_user">
                                <option value="">Sin usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->id }} .- {{ $user->name }}
                                    </option>
                                @endforeach
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
        var editResponsibleModal = document.getElementById('editResponsibleModal');
        editResponsibleModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var responsibleId = button.getAttribute('data-responsible-id');
            var responsibleCardId = button.getAttribute('data-responsible-card_id');
            var responsibleName = button.getAttribute('data-responsible-name');
            var responsibleLastName = button.getAttribute('data-responsible-last_name');
            var responsibleArea = button.getAttribute('data-responsible-area');
            var responsibleRole = button.getAttribute('data-responsible-role');
            var responsibleStatus = button.getAttribute('data-responsible-status');
            var responsibleIdUser = button.getAttribute('data-responsible-id_user');

            var modalForm = editResponsibleModal.querySelector('form');
            modalForm.action = '/info/responsibles/' + responsibleId;

            var modalCardIdInput = editResponsibleModal.querySelector('#edit_card_id');
            var modalNameInput = editResponsibleModal.querySelector('#edit_name');
            var modalLastNameInput = editResponsibleModal.querySelector('#edit_last_name');
            var modalAreaInput = editResponsibleModal.querySelector('#edit_area');
            var modalRoleInput = editResponsibleModal.querySelector('#edit_role');
            var modalStatusInput = editResponsibleModal.querySelector('#edit_status');
            var modalIdUserInput = editResponsibleModal.querySelector('#edit_id_user');

            modalCardIdInput.value = responsibleCardId;
            modalNameInput.value = responsibleName;
            modalLastNameInput.value = responsibleLastName;
            modalAreaInput.value = responsibleArea;
            modalRoleInput.value = responsibleRole;
            modalStatusInput.value = responsibleStatus;
            modalIdUserInput.value = responsibleIdUser;
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $responsibles->count() }};
        const tableId = 'table-responsibles';
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
            deleteUrl: "{{ route('responsible.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#responsible_ids"
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeDeactivateAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deactivateButtonId: "#deactivateSelected",
            deactivateUrl: "{{ route('responsible.deactivate') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#responsible_ids"
        });
    });
</script>
