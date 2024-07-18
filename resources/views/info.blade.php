<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-5 tw-gap-6">
                @role('administrador')
                    <a href="{{ route('users.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">

                            <img src="{{ asset('assets/img/logos/user.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Usuario Logo">
                            <h5
                                class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Usuarios
                            </h5>

                        </div>
                    </a>
                @endrole
                @role('administrador|coordinador|rector')
                    <a href="{{ route('students.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/student.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Student Logo">
                            <h5
                                class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Estudiantes
                            </h5>

                        </div>
                    </a>

                    <a href="{{ route('periods.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/period.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Periodo Logo">
                            <h5
                                class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Periodos
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('categories_warehouse.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/cat-warehouse.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Categoria de bodega Logo">
                            <h5
                                class="tw-mb-2 tw-text-2xl tw-font-bold tw-text-center tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Categorías de Bodega
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('warehouses.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/warehouse.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Warehouse Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Bodegas
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('responsibles.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/responsible.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Responsable Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Responsables
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('modules.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/module.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Modulo Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Módulos
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('categories_items.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">

                            <img src="{{ asset('assets/img/logos/cat-item.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Categoria de item Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Categorías de ítems
                            </h5>

                        </div>
                    </a>

                    <a href="{{ route('operations.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">

                            <img src="{{ asset('assets/img/logos/operation-type.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Tipo de operacion Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Tipos de operaciones
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('measurement_units.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">

                            <img src="{{ asset('assets/img/logos/unit.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Medida de unidad Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Medidas de unidad
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('projects.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/project.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Proyecto Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Proyectos
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('tasks.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/task.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Task Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Tareas
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('items.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/item.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Item Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Items
                            </h5>

                        </div>
                    </a>
                    <a href="{{ route('kardex.index') }}">
                        <div
                            class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                            <img src="{{ asset('assets/img/logos/kardex.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3"
                                alt="Kardex Logo">
                            <h5
                                class="tw-text-center tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">
                                Kardex
                            </h5>

                        </div>
                    </a>
                @endrole

            </div>
        </div>
    </main>
</x-app-layout>
