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
                                        <h5 class="">Administración de Kardex</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los registros de kardex.</p>
                                    @else
                                        <h5 class="">Registros de Kardex</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los registros de kardex.</p>
                                    @endrole
                                </div>

                                <div class="col-6 text-end">
                                    @role('rector|jefe de proyecto')
                                        <button type="button" class="btn btn-success btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createKardexModal">
                                            <i class="fas fa-plus me-2"></i> Agregar entrada
                                        </button>
                                    @endrole
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
                                            <a class="dropdown-item" href="{{ route('kardex.pdf') }}"
                                                id="pdf">PDF</a>
                                            <a class="dropdown-item" href="{{ route('kardex.download-excel') }}"
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
                                    <input type="text" id="table-search-kardex"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar kardex..."
                                        onkeyup="searchTable('table-search-kardex', 'table-kardex')">
                                </div>
                            </div>
                            <table id="table-kardex"
                                class="tw-w-full tw-text-sm tw-text-left tw-rtl:tw-text-right tw-text-gray-500 dark:tw-text-gray-400">
                                <thead
                                    class="tw-text-xs tw-text-gray-700 tw-uppercase tw-bg-gray-50 dark:tw-bg-gray-700 dark:tw-text-gray-400">
                                    <tr>
                                        @role('rector|jefe de proyecto')
                                            <th scope="col" class="tw-p-4">
                                                <div class="tw-flex tw-items-center">
                                                    <input id="select_all_ids" type="checkbox"
                                                        class="tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                </div>
                                            </th>
                                        @endrole
                                        <th scope="col" class="tw-px-6 tw-py-3">Fecha</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">ID</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Operación</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Almacén</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Proyecto</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Ítem</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Detalle</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Cantidad</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Precio</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Balance</th>
                                        @role('rector|jefe de proyecto')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kardexEntries as $entry)
                                        <tr id="kardex_ids{{ $entry->id_kardex }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('rector|jefe de proyecto')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $entry->id_kardex }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">
                                                {{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->id_kardex }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->operationType->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->warehouse->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->project->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->item->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->detail }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->quantity }}</td>
                                            <td class="tw-px-6 tw-py-4">${{ number_format($entry->price, 2) }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $entry->balance }}</td>
                                            @role('|jefe de proyecto')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editKardexModal"
                                                        data-kardex-id="{{ $entry->id_kardex }}"
                                                        data-kardex-operation="{{ $entry->id_ope }}"
                                                        data-kardex-warehouse="{{ $entry->id_ware }}"
                                                        data-kardex-project="{{ $entry->id_pro }}"
                                                        data-kardex-item="{{ $entry->id_item }}"
                                                        data-kardex-detail="{{ $entry->detail }}"
                                                        data-kardex-date="{{ $entry->date }}"
                                                        data-kardex-quantity="{{ $entry->quantity }}"
                                                        data-kardex-price="{{ $entry->price }}"
                                                        data-kardex-balance="{{ $entry->balance }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('kardex.destroy', $entry->id_kardex) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar esta entrada de kardex?')">
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

    <!-- Create Kardex Modal -->
    <div class="modal fade" id="createKardexModal" tabindex="-1" aria-labelledby="createKardexModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createKardexModalLabel">Agregar entrada de Kardex</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createKardexForm" method="POST" action="{{ route('kardex.store') }}">
                        @csrf
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_ope" class="form-label">Tipo de Operación</label>
                                <select class="form-control" id="id_ope" name="id_ope" required>
                                    @foreach ($operationTypes as $operationType)
                                        <option value="{{ $operationType->id_ope }}">{{ $operationType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('operations.index') }}" class="btn btn-info">Agregar Tipo de
                                    Operación</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="id_ware" class="form-label">Almacén</label>
                            <select class="form-control" id="id_ware" name="id_ware" required>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id_ware }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_pro" class="form-label">Proyecto</label>
                            <select class="form-control" id="id_pro" name="id_pro" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id_pro }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="id_item" class="form-label">Ítem</label>
                            <select class="form-control" id="id_item" name="id_item" required>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id_item }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="form-label">Detalle</label>
                            <textarea class="form-control" id="detail" name="detail" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="price" name="price" step="any"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="balance" class="form-label">Balance</label>
                            <input type="number" class="form-control" id="balance" name="balance" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Kardex Modal -->
    <div class="modal fade" id="editKardexModal" tabindex="-1" aria-labelledby="editKardexModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editKardexModalLabel">Editar Entrada de Kardex</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editKardexForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="edit_id_ope" class="form-label">Tipo de Operación</label>
                                <select class="form-control" id="edit_id_ope" name="id_ope" required>
                                    @foreach ($operationTypes as $operationType)
                                        <option value="{{ $operationType->id_ope }}">
                                            {{ $operationType->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <a href="{{ route('operations.index') }}" class="btn btn-info">Agregar Tipo de
                                    Operación</a>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_ware" class="form-label">Almacén</label>
                            <select class="form-control" id="edit_id_ware" name="id_ware" required>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id_ware }}">
                                        {{ $warehouse->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_pro" class="form-label">Proyecto</label>
                            <select class="form-control" id="edit_id_pro" name="id_pro" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id_pro }}">
                                        {{ $project->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_item" class="form-label">Ítem</label>
                            <select class="form-control" id="edit_id_item" name="id_item" required>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id_item }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_detail" class="form-label">Detalle</label>
                            <textarea class="form-control" id="edit_detail" name="detail" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Precio</label>
                            <input type="number" class="form-control" id="edit_price" name="price"
                                step="any" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_balance" class="form-label">Balance</label>
                            <input type="number" class="form-control" id="edit_balance" name="balance" required>
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
        var editKardexModal = document.getElementById('editKardexModal');
        editKardexModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var kardexId = button.getAttribute('data-kardex-id');
            var kardexOperation = button.getAttribute('data-kardex-operation');
            var kardexWarehouse = button.getAttribute('data-kardex-warehouse');
            var kardexProject = button.getAttribute('data-kardex-project');
            var kardexItem = button.getAttribute('data-kardex-item');
            var kardexDetail = button.getAttribute('data-kardex-detail');
            var kardexDate = button.getAttribute('data-kardex-date');
            var kardexQuantity = button.getAttribute('data-kardex-quantity');
            var kardexPrice = button.getAttribute('data-kardex-price');
            var kardexBalance = button.getAttribute('data-kardex-balance');

            var modalForm = editKardexModal.querySelector('form');
            modalForm.action = '/info/kardex/' + kardexId;

            var modalOperationInput = editKardexModal.querySelector('#edit_id_ope');
            var modalWarehouseInput = editKardexModal.querySelector('#edit_id_ware');
            var modalProjectInput = editKardexModal.querySelector('#edit_id_pro');
            var modalItemInput = editKardexModal.querySelector('#edit_id_item');
            var modalDetailInput = editKardexModal.querySelector('#edit_detail');
            var modalDateInput = editKardexModal.querySelector('#edit_date');
            var modalQuantityInput = editKardexModal.querySelector('#edit_quantity');
            var modalPriceInput = editKardexModal.querySelector('#edit_price');
            var modalBalanceInput = editKardexModal.querySelector('#edit_balance');

            modalOperationInput.value = kardexOperation;
            modalWarehouseInput.value = kardexWarehouse;
            modalProjectInput.value = kardexProject;
            modalItemInput.value = kardexItem;
            modalDetailInput.value = kardexDetail;
            modalDateInput.value = kardexDate;
            modalQuantityInput.value = kardexQuantity;
            modalPriceInput.value = kardexPrice;
            modalBalanceInput.value = kardexBalance;
        });

        const totalRecords = {{ $kardexEntries->count() }};
        const tableId = 'table-kardex';
        const paginationContainerId = 'pagination-numbers';
        const defaultRecordsPerPage = 10;

        initPagination(totalRecords, tableId, paginationContainerId, defaultRecordsPerPage);
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeDeleteAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deleteButtonId: "#deleteSelected",
            deleteUrl: "{{ route('kardex.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#kardex_ids"
        });
    });
</script>
