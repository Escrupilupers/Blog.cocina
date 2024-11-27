<!-- pollo-herbas.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pollo a las Hierbas</title>
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

    <!-- Receta de Pollo a las Hierbas -->
    <section class="container my-5">
        <h1 class="text-center">Pollo a las Hierbas</h1>
        <div class="row">
            <div class="col-md-6">
                <img src="ruta-de-imagen-pollo.jpg" class="img-fluid" alt="Pollo a las Hierbas">
            </div>
            <div class="col-md-6">
                <h3>Ingredientes</h3>
                <ul>
                    <li>4 muslos de pollo</li>
                    <li>2 cucharadas de aceite de oliva</li>
                    <li>Romero, tomillo y orégano</li>
                    <li>Sal y pimienta al gusto</li>
                </ul>
                <h3>Instrucciones</h3>
                <ol>
                    <li>Precalentar el horno a 180°C.</li>
                    <li>Frotar el pollo con aceite de oliva y las hierbas.</li>
                    <li>Hornear durante 45 minutos o hasta que esté dorado.</li>
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
