<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu Dirección de Correo Electrónico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
            width: 500px; /* Aumentado el ancho */
        }
        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .alert {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Verifica tu Dirección de Correo Electrónico</h1>
        <p>Antes de continuar, por favor revisa tu correo electrónico para encontrar el enlace de verificación.</p>
        <p>Si no recibiste el correo, haz clic en el botón de abajo para solicitar otro.</p>
        @if (session('resent'))
            <div class="alert">
                Un nuevo enlace de verificación ha sido enviado a tu dirección de correo electrónico.
            </div>
        @endif
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit">Reenviar Correo de Verificación</button>
        </form>
    </div>
</body>
</html>
