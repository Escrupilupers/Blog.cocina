<!-- mousse-chocolate.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mousse de Chocolate</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\assets\estilo.css">
</head>
<body>
    <!-- Barra de navegación -->
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

    <!-- Receta de Mousse de Chocolate -->
    <section class="container my-5">
        <h1 class="text-center">Mousse de Chocolate</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="ruta-de-imagen.jpg" class="img-fluid" alt="Mousse de Chocolate">
            </div>
            <div class="col-md-6">
                <h3>Ingredientes</h3>
                <ul>
                    <li>200g de chocolate negro</li>
                    <li>200ml de crema para batir</li>
                    <li>4 huevos</li>
                    <li>50g de azúcar</li>
                </ul>
                <h3>Instrucciones</h3>
                <ol>
                    <li>Fundir el chocolate al baño maría.</li>
                    <li>Batir las claras a punto de nieve con el azúcar.</li>
                    <li>Incorporar las claras y la crema al chocolate derretido.</li>
                    <li>Refrigerar durante 4 horas antes de servir.</li>
                </ol>
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
