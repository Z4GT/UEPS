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
                                    @role('rector')
                                        <h5 class="">Administración de Items</h5>
                                        <p class="mb-0 text-sm">Aquí puedes gestionar los ítems.</p>
                                    @else
                                        <h5 class="">Items</h5>
                                        <p class="mb-0 text-sm">Aquí puedes visualizar los ítems.</p>
                                    @endrole
                                </div>
                                @role('rector')
                                    <div class="col-6 text-end">
                                        <button type="button" class="btn btn-success btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#createItemModal">
                                            <i class="fas fa-plus me-2"></i> Agregar ítem
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

                        <div id="message"
                            class="tw-hidden tw-bg-green-100 tw-border tw-border-green-400 tw-text-green-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Éxito!</strong>
                            <span class="tw-block sm:tw-inline" id="message-text"></span>
                        </div>

                        <div id="error-message"
                            class="tw-hidden tw-bg-red-100 tw-border tw-border-red-400 tw-text-red-700 tw-px-4 tw-py-3 tw-rounded tw-relative"
                            role="alert">
                            <strong class="tw-font-bold">Error!</strong>
                            <span class="tw-block sm:tw-inline" id="error-message-text"></span>
                        </div>

                        <div class="tw-relative tw-overflow-x-auto tw-shadow-md sm:tw-rounded-lg tw-p-5">
                            <div
                                class="tw-flex tw-items-center tw-justify-between tw-pb-4 tw-bg-white dark:tw-bg-gray-900">
                                <div class="d-flex flex-row justify-content-start">
                                    @role('rector')
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
                                    @endrole
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button"
                                            id="sortDropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false">
                                            Ordenar por
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="sortDropdownMenuButton">
                                            <a class="dropdown-item" href="?sort=created_at&direction=desc">Nuevos</a>
                                            <a class="dropdown-item" href="?sort=created_at&direction=asc">Antiguos</a>

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
                                    <input type="text" id="table-search-items"
                                        class="tw-block tw-p-2 tw-ps-10 tw-text-sm tw-text-gray-900 tw-border tw-border-gray-300 tw-rounded-lg tw-w-80 tw-bg-gray-50 focus:tw-ring-blue-500 focus:tw-border-blue-500 dark:tw-bg-gray-700 dark:tw-border-gray-600 dark:tw-placeholder-gray-400 dark:tw-text-white dark:focus:tw-ring-blue-500 dark:focus:tw-border-blue-500"
                                        placeholder="Buscar ítem..."
                                        onkeyup="searchTable('table-search-items', 'table-items')">
                                </div>
                            </div>
                            <table id="table-items"
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
                                                    href="?sort=id_item&direction={{ $sortField === 'id_item' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
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
                                        <th scope="col" class="tw-px-6 tw-py-3">Descripción</th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Fecha
                                                <a
                                                    href="?sort=date&direction={{ $sortField === 'date' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Proyecto
                                                <a
                                                    href="?sort=id_pro&direction={{ $sortField === 'id_pro' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Categoría
                                                <a
                                                    href="?sort=id_catitem&direction={{ $sortField === 'id_catitem' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Unidad de Medida
                                                <a
                                                    href="?sort=id_unit&direction={{ $sortField === 'id_unit' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">
                                            <div class="tw-flex tw-items-center">
                                                Stock
                                                <a
                                                    href="?sort=stock&direction={{ $sortField === 'stock' && $sortDirection === 'asc' ? 'desc' : 'asc' }}">
                                                    <img class="tw-w-3 tw-h-3 tw-ms-1.5" aria-hidden="true"
                                                        src="{{ asset('assets/img/logos/up-down.svg') }}">
                                                </a>
                                            </div>
                                        </th>
                                        <th scope="col" class="tw-px-6 tw-py-3">Etiquetas</th>
                                        @role('rector')
                                            <th scope="col" class="tw-px-6 tw-py-3">Acción</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $item)
                                        <tr id="item_ids{{ $item->id_item }}"
                                            class="tw-bg-white tw-border-b dark:tw-bg-gray-800 dark:tw-border-gray-700 hover:tw-bg-gray-50 dark:hover:tw-bg-gray-600">
                                            @role('rector')
                                                <td class="tw-w-4 tw-p-4">
                                                    <div class="tw-flex tw-items-center">
                                                        <input type="checkbox" value="{{ $item->id_item }}"
                                                            class="checkbox_ids tw-w-4 tw-h-4 tw-text-blue-600 tw-bg-gray-100 tw-border-gray-300 tw-rounded focus:tw-ring-blue-500 dark:focus:tw-ring-blue-600 dark:tw-ring-offset-gray-800 dark:focus:tw-ring-offset-gray-800 focus:tw-ring-2 dark:tw-bg-gray-700 dark:tw-border-gray-600">
                                                    </div>
                                                </td>
                                            @endrole
                                            <td class="tw-px-6 tw-py-4">{{ $item->id_item }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->name }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="toggle-description tw-text-blue-600 hover:tw-underline"
                                                    data-item-id="{{ $item->id_item }}">
                                                    <img src="{{ asset('assets/img/logos/plus.svg') }}"
                                                        class="tw-w-5 tw-h-5">
                                                </button>
                                                <div class="description-content tw-hidden tw-mt-2">
                                                    {{ $item->description }}
                                                </div>
                                            </td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->date }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->project->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->category->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->unit->name }}</td>
                                            <td class="tw-px-6 tw-py-4">{{ $item->stock }}</td>
                                            <td class="tw-px-6 tw-py-4">
                                                <button class="toggle-tags tw-text-blue-600 hover:tw-underline"
                                                    data-item-id="{{ $item->id_item }}">
                                                    <img src="{{ asset('assets/img/logos/plus.svg') }}"
                                                        class="tw-w-5 tw-h-5">
                                                </button>
                                                <div class="tags-content tw-hidden tw-mt-2">
                                                    <div class="tw-flex tw-flex-wrap tw-gap-1">
                                                        @foreach ($item->tags as $tag)
                                                            <span
                                                                class="tw-bg-gray-200 tw-rounded-full tw-px-3 tw-py-1 tw-text-sm tw-font-semibold tw-text-gray-700">
                                                                {{ $tag->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </td>
                                            @role('rector')
                                                <td class="tw-px-6 tw-py-4 tw-flex tw-space-x-2">
                                                    <a href="#"
                                                        class="tw-font-medium tw-text-blue-600 dark:tw-text-blue-500 hover:tw-underline"
                                                        data-bs-toggle="modal" data-bs-target="#editItemModal"
                                                        data-item-id="{{ $item->id_item }}"
                                                        data-item-name="{{ $item->name }}"
                                                        data-item-description="{{ $item->description }}"
                                                        data-item-date="{{ $item->date }}"
                                                        data-item-project="{{ $item->id_pro }}"
                                                        data-item-category="{{ $item->id_catitem }}"
                                                        data-item-unit="{{ $item->id_unit }}"
                                                        data-item-stock="{{ $item->stock }}">
                                                        <svg class="tw-w-6 tw-h-6 tw-text-gray-800 dark:tw-text-white"
                                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                            width="24" height="24" fill="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path fill-rule="evenodd"
                                                                d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </a>
                                                    <form action="{{ route('items.destroy', $item->id_item) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="tw-font-medium tw-text-red-600 dark:tw-text-red-500 hover:tw-underline"
                                                            onclick="return confirm('¿Estás seguro de que deseas eliminar este ítem?')">
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

    <!-- Create Item Modal -->
    <div class="modal fade" id="createItemModal" tabindex="-1" aria-labelledby="createItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createItemModalLabel">Agregar ítem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createItemForm" method="POST" action="{{ route('items.store') }}">
                        @csrf
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_catitem" class="form-label">Categoría</label>
                                <select class="form-control" id="id_catitem" name="id_catitem" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_catitem }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createCategoryItemModal">Agregar Categoría</button>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="id_unit" class="form-label">Unidad de Medida</label>
                                <select class="form-control" id="id_unit" name="id_unit" required>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id_unit }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createUnitModal">Agregar Unidad</button>
                            </div>
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
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Etiquetas</label>
                            <div id="SelectBoxCreate" style="width: 100%;"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Editar ítem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="editItemForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="edit_id_catitem" class="form-label">Categoría</label>
                                <select class="form-control" id="edit_id_catitem" name="id_catitem" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id_catitem }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createCategoryItemModal">Agregar Categoría</button>
                            </div>
                        </div>
                        <div class="mb-3 d-flex">
                            <div class="me-2">
                                <label for="edit_id_unit" class="form-label">Unidad de Medida</label>
                                <select class="form-control" id="edit_id_unit" name="id_unit" required>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id_unit }}">{{ $unit->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="pt-4">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#createUnitModal">Agregar Unidad</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_id_pro" class="form-label">Proyecto</label>
                            <select class="form-control" id="edit_id_pro" name="id_pro" required>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id_pro }}">{{ $project->name }}</option>
                                @endforeach
                            </select>
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
                            <label for="edit_date" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="edit_date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="edit_stock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Etiquetas</label>
                            <div id="SelectBoxEdit" style="width: 100%;"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Category Item Modal -->
    <div class="modal fade" id="createCategoryItemModal" tabindex="-1"
        aria-labelledby="createCategoryItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createCategoryItemModalLabel">Agregar categoría de ítem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createCategoryItemForm" method="POST" action="{{ route('categories_items.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Unit Modal -->
    <div class="modal fade" id="createUnitModal" tabindex="-1" aria-labelledby="createUnitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUnitModalLabel">Agregar unidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="background-color: red"></button>
                </div>
                <div class="modal-body">
                    <form id="createUnitForm" method="POST" action="{{ route('measurement_units.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="symbol" class="form-label">Unidad de medida</label>
                            <input type="text" class="form-control" id="symbol" name="symbol" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- jQuery selectit plugin -->
<link rel="stylesheet" href="../assets/css/jquery.selectit.css" />
<script src="{{ asset('assets/js/jquery.selectit.js') }}"></script>
<script>
    $(function() {
        $('#SelectBoxCreate').selectit({
            fieldname: 'tags[]',
        });

        var editItemModal = document.getElementById('editItemModal');
        editItemModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var itemId = button.getAttribute('data-item-id');
            var itemName = button.getAttribute('data-item-name');
            var itemDescription = button.getAttribute('data-item-description');
            var itemDate = button.getAttribute('data-item-date');
            var itemProject = button.getAttribute('data-item-project');
            var itemCategory = button.getAttribute('data-item-category');
            var itemUnit = button.getAttribute('data-item-unit');
            var itemStock = button.getAttribute('data-item-stock');

            var modalForm = editItemModal.querySelector('form');
            modalForm.action = '/info/items/' + itemId;

            var modalNameInput = editItemModal.querySelector('#edit_name');
            var modalDescriptionInput = editItemModal.querySelector('#edit_description');
            var modalDateInput = editItemModal.querySelector('#edit_date');
            var modalProjectInput = editItemModal.querySelector('#edit_id_pro');
            var modalCategoryInput = editItemModal.querySelector('#edit_id_catitem');
            var modalUnitInput = editItemModal.querySelector('#edit_id_unit');
            var modalStockInput = editItemModal.querySelector('#edit_stock');

            modalNameInput.value = itemName;
            modalDescriptionInput.value = itemDescription;
            modalDateInput.value = itemDate;
            modalProjectInput.value = itemProject;
            modalCategoryInput.value = itemCategory;
            modalUnitInput.value = itemUnit;
            modalStockInput.value = itemStock;

            $.ajax({
                url: '/items/' + itemId + '/tags',
                method: 'GET',
                success: function(data) {
                    $('#SelectBoxEdit').selectit({
                        fieldname: 'tags[]',
                        values: data.tags
                    });
                }
            });
        });
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

    // Toggle tags visibility
    document.querySelectorAll('.toggle-tags').forEach(button => {
        button.addEventListener('click', function() {
            const tagsContent = this.nextElementSibling;
            if (tagsContent.classList.contains('tw-hidden')) {
                tagsContent.classList.remove('tw-hidden');
                this.querySelector('img').src =
                    '{{ asset('assets/img/logos/minus.svg') }}';
            } else {
                tagsContent.classList.add('tw-hidden');
                this.querySelector('img').src = '{{ asset('assets/img/logos/plus.svg') }}';
            }
        });
    });


    document.addEventListener('DOMContentLoaded', function() {
        const totalRecords = {{ $items->count() }};
        const tableId = 'table-items';
        const paginationContainerId = 'pagination-numbers';
        const defaultRecordsPerPage = 10;

        initPagination(totalRecords, tableId, paginationContainerId, defaultRecordsPerPage);
    });

    document.addEventListener('DOMContentLoaded', function() {
        initializeDeleteAll({
            selectAllId: "#select_all_ids",
            checkboxClass: ".checkbox_ids",
            deleteButtonId: "#deleteSelected",
            deleteUrl: "{{ route('item.delete') }}",
            csrfToken: "{{ csrf_token() }}",
            rowIdPrefix: "#item_ids"
        });
    });
</script>
