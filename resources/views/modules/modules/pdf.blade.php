<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link href="{{ public_path('assets/css/tailwind.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <title>{{ $title }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .Encabezado {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin: 0 auto;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
            word-wrap: break-word;
        }

        .thead-dark th {
            background-color: #8ABF54 !important;
            color: white;
            border-color: #8ABF54 !important;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="Encabezado">
            <img src="{{ public_path('assets/img/logohorizontal.png') }}" alt="Logo" style="width: 300px; height: 100px; margin:auto;">
        </div>

        <p class="h2" style="color: #4E64A6">{{ $title }}</p>
        <div style="display: flex; align-items: center;">
            <p class="h4" style="margin-right: 2px; color: #4E64A6;">Fecha y hora:</p>
            <p style="color: #4E64A6">{{ $date }}</p>
        </div>

        <div class="table-container">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Responsable del Modulo</th>
                        <th scope="col">Periodo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Fecha de Inicio</th>
                        <th scope="col">Fecha de Finalización</th>
                        <th scope="col">Horas de Vinculacion</th>
                        <th scope="col">Estado</th>

                        

                    </tr>
                </thead>
                <tbody>
                    @foreach ($modules as $module)
                    <tr>
                        <td>{{ $module->responsible->name }} {{$module->responsible->last_name}}</td>
                        <td>{{ $module->period->name }}
                            {{ $module->period->academic_year }}</td>
                        <td>{{ $module->name }}</td>
                        <td>{{ $module->start_date }}</td>
                        <td>{{ $module->end_date }}</td>
                        <td>{{ $module->vinculation_hours }}</td>
                        <td> {{ $module->status ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
