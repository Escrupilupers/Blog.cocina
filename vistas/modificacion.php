<!-- modificacion-de-receta.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación de Receta</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\assets\estilo.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">A Cocinar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="plantilla.php">Recetas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tips.php">Tips de cocina</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre-nosotros.php">Sobre nosotros</a>
                    </li>
                </ul>
                <button class="btn btn-warning ms-3">Subscríbete</button>
            </div>
        </div>
    </nav>
    <section class="container my-5">
        <h1 class="text-center">Modificación de Receta</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="..\assets\images\imagenes\fallout.jpg" class="img-fluid" alt="Modificar receta">
            </div>
            <div class="col-md-6">
                <h3>Consejos para Modificar una Receta:</h3>
                <ul>
                    <li><strong>Haz sustituciones inteligentes:</strong> Si no tienes un ingrediente, busca uno similar que no altere demasiado el sabor del platillo.</li>
                    <li><strong>Ajusta las cantidades:</strong> Si quieres hacer más o menos de una receta, ajusta las cantidades de los ingredientes proporcionalmente.</li>
                    <li><strong>Prueba diferentes técnicas de cocción:</strong> Experimenta con distintos métodos, como hornear, asar o hervir, para ver cuál realza mejor los sabores de los ingredientes.</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
