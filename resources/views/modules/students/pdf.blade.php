<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <link href="{{ public_path('assets/css/tailwind.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css">

    <title>{{ $title }}</title>


</head>

<body>
    <p class="h2">{{ $title }}</p>
    <div style="display: flex; align-items: center;">
        <p class="h4" style="margin-right: 2px;">Fecha y hora:</p>
        <p>{{ $date }}</p>
    </div>

    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Cédula</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td scope="row">{{ $student->id_stud }}</td>
                    <td scope="row">{{ $student->card_id }}</td>
                    <td scope="row">{{ $student->name }}</td>
                    <td scope="row">{{ $student->last_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</body>

</html>
