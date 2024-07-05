<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada</title>

    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://unpkg.com/bs-brain@2.0.4/components/error-404s/error-404-1/assets/css/error-404-1.css">
    <!-- Añadir cualquier otro CSS o JS necesario -->
</head>


<body>
    <!-- Error 404 Template 1 - Bootstrap Brain Component -->
    <section class="py-3 py-md-5 min-vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        <h2 class="d-flex justify-content-center align-items-center gap-2 mb-4">
                            <span class="display-1 fw-bold">5</span>
                            <i class="bi bi-exclamation-circle-fill text-danger display-4"></i>
                            <span class="display-1 fw-bold">3</span>
                        </h2>
                        <h3 class="h2 mb-2">Servicio No Disponible.</h3>
                        <p class="mb-5">El servidor está temporalmente no disponible. Por favor, inténtalo más tarde.
                        </p>
                        <a class="btn bsb-btn-5xl btn-dark rounded-pill px-5 fs-6 m-0" href="{{ url('/') }}"
                            role="button">Regresar a Inicio</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
