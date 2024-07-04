<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-app.navbar />
        <div class="container-fluid py-6">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header pb-0">
                            <h3 style="margin-left: 5vh;">Datos Generales</h3>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <div style="display: flex;">
                                <div style="margin-top: 7vh; margin-left: 5vh;">
                                    <p style="font-weight: bold; color: #0F172A;">Nombre del Proyecto:</p>
                                    <p style="font-weight: bold; color: #0F172A;">Responsable del Proyecto:</p>
                                    <p style="font-weight: bold; color: #0F172A;">Periodo del Proyecto:</p>
                                    <p style="font-weight: bold; color: #0F172A;">Presupuesto del proyecto:</p>
                                </div>
                                <div style="margin-top: 7vh; margin-left: 5vh;">
                                    <p>Proyecto de Producción de Hortalizas</p>
                                    <p>Ing. Juan Perez</p>
                                    <p>2021-2022</p>
                                    <p>$ 1000</p>
                                </div>
                            </div>
                            <div class="col-4" style="background-color: rgb(143, 143, 143); border-radius: 2%; margin-top: 3vh; margin-right: 5vh; width: 400px; height: 210px;">
                                <img src="../assets/img/cuy1.png" alt="ues" style="margin: auto; width=100%; height:100%; padding:5%">
                            </div>
                        </div>
                        <div style="margin-top: 2vh; margin-right: 0;">
                            <div style="width: 90%; margin: auto; border-bottom: 3px solid #0F172A;">
                                <ul id="menu" style="width: 90%; display: flex; justify-content: space-between; padding: 0; margin: auto;">
                                    <li>
                                        <p id="tareas" style="font-weight: bold;">Tareas</p>
                                    </li>
                                    <li>
                                        <p id="kardex" style="font-weight: bold;">Kardex</p>
                                    </li>
                                    <li>
                                        <p id="descripcion" style="font-weight: bold;">Descripcion</p>
                                    </li>
                                    <li>
                                        <p id="recursos" style="font-weight: bold;">Recursos</p>
                                    </li>
                                </ul>
                            </div>
                            <div id="tareas-content" class="contenidos" style="width: 100%; padding-left: 5%; padding-right: 5%; margin-top: 2vh;">
                                <div class="px-5 py-4 container-fluid">
                                    <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 md:tw-grid-cols-3 lg:tw-grid-cols-5 tw-gap-6">
                                        <div class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                                            <img src="{{ asset('assets/img/logos/user.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3" alt="Usuario Logo">
                                            <h5 class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">Tarea 1</h5>
                                            <p class="tw-mb-3 tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">Descripción</p>
                                        </div>
                                        <div class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                                            <img src="{{ asset('assets/img/logos/student.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3" alt="Student Logo">
                                            <h5 class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">Tarea 2</h5>
                                            <p class="tw-mb-3 tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">Descripción</p>
                                        </div>
                                        <div class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                                            <img src="{{ asset('assets/img/logos/user.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3" alt="Usuario Logo">
                                            <h5 class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">Tarea 3</h5>
                                            <p class="tw-mb-3 tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">Descripción</p>
                                        </div>
                                        <div class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                                            <img src="{{ asset('assets/img/logos/student.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3" alt="Student Logo">
                                            <h5 class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">Tarea 4</h5>
                                            <p class="tw-mb-3 tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">Descripción</p>
                                        </div>
                                        <div class="tw-max-w-sm tw-p-6 tw-bg-white tw-border tw-border-gray-200 tw-rounded-lg tw-shadow dark:tw-bg-gray-800 dark:tw-border-gray-700 tw-flex tw-flex-col tw-items-center">
                                            <img src="{{ asset('assets/img/logos/user.svg') }}" class="tw-w-10 tw-h-10 tw-mb-3" alt="Usuario Logo">
                                            <h5 class="tw-mb-2 tw-text-2xl tw-font-bold tw-tracking-tight tw-text-gray-900 dark:tw-text-white">Tarea 5</h5>
                                            <p class="tw-mb-3 tw-font-normal tw-text-gray-500 dark:tw-text-gray-400">Descripción</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="kardex-content" class="contenidos" style="width: 100%; padding-left: 5%; padding-right: 5%;">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Fecha</th>
                                            <th>Cantidad</th>
                                            <th>Saldo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lechuga</td>
                                            <td>01/01/2021</td>
                                            <td>100</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td>Lechuga</td>
                                            <td>09/01/2021</td>
                                            <td>100</td>
                                            <td>200</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="descripcion-content" class="contenidos" style="width: 100%; padding-left: 5%; padding-right: 5%;">
                                <p style="text-align: center; margin-top: 2%; color: #0F172A;">La Unidad Educativa de Producción establece el proyecto didáctico productivo con el propósito de crear un ambiente de práctica y producción permanente, la meta productiva es de engordar dos porcinos mensuales, los cuales ingresan de 60 días de edad ya con todas las vacunas respectivas, los cuales son criados por 90 días utilizando una tabla de nutrición diseñada para cumplir con el objetivo, los animales al final son faenados y la carne es comercializada en el punto de venta de la misma unidad a los Padres de Familia, Funcionarios y Ciudadanía en general</p>
                            </div>
                            <div id="recursos-content" class="contenidos" style="width: 100%; padding-left: 5%; padding-right: 5%;">
                                <table class="custom-table">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Descargar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Información del Proyecto</td>
                                            <td>Archivo de información del proyecto</td>
                                            <td><img src="https://img.icons8.com/ios-filled/50/000000/download.png" alt="Descargar" style="width: 20px; height: 20px; justify-content: center; margin: auto;"></td>
                                        </tr>
                                        <tr>
                                            <td>Presupuesto</td>
                                            <td>Archivo de presupuesto del proyecto</td>
                                            <td><img src="https://img.icons8.com/ios-filled/50/000000/download.png" alt="Descargar" style="width: 20px; height: 20px; margin: auto;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

<style>
    .contenidos {
        display: none;
    }
    .selected {
        border-bottom: 1px black solid;
        color: white; /* Cambia el color de las letras a blanco */
    }
    #menu p {
        cursor: pointer;
        color: #0F172A;
    }
    #menu p:hover {
        border-radius: 0;
        border-bottom: 1px black solid;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        margin-bottom: 4vh;

    }
    .custom-table th, .custom-table td {
        border-bottom: 3px solid black;
        padding: 10px;
        text-align: center;
        color: #0F172A;
    }
    .custom-table th {
        background-color: #f4f4f4;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('menu');
    const contents = document.querySelectorAll('.contenidos');
    const menuItems = menu.querySelectorAll('p');

    // Function to show the target content
    function showContent(targetId) {
        // Remove 'selected' class from all menu items
        menuItems.forEach(item => item.classList.remove('selected'));

        // Hide all content
        contents.forEach(content => content.style.display = 'none');

        // Add 'selected' class to the selected menu item
        const selectedItem = document.getElementById(targetId.replace('-content', ''));
        if (selectedItem) {
            selectedItem.classList.add('selected');
        }

        // Show the target content
        const targetContent = document.getElementById(targetId);
        if (targetContent) {
            targetContent.style.display = 'block';
        }
    }

    // Check localStorage for the last selected item
    const lastSelected = localStorage.getItem('lastSelected') || 'tareas-content';
    showContent(lastSelected);

    menu.addEventListener('click', function (e) {
        if (e.target && e.target.closest('p')) {
            const p = e.target.closest('p');
            const targetId = p.id + '-content';

            // Save the selected item to localStorage
            localStorage.setItem('lastSelected', targetId);

            // Show the target content
            showContent(targetId);
        }
    });
});
</script>
