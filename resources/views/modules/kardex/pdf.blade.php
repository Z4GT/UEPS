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
            max-width: 100%;
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
                        <th scope="col">Fecha</th>
                        <th scope="col">ID</th>
                        <th scope="col">Operación</th>
                        <th scope="col">Almacen</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Item</th>
                        <th scope="col">Cantidad</th>
                        <th scope="col">Stock</th>                        
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kardexEntries as $entry)
                    <tr>
                        <td class="tw-px-6 tw-py-4">
                            {{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->id_kardex }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->operationType->name }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->warehouse->name }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->project->name }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->item->name }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->quantity }}</td>
                        <td class="tw-px-6 tw-py-4">{{ $entry->balance }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
