<?php 
require "../config/Conexion.php";

if (isset($_GET['categoria'])) {
    $categoria = $_GET['categoria'];
    $query_recetas_categoria = "SELECT r.id_receta, r.titulo, r.categoria, i.ruta_imagen 
                                FROM recetas AS r
                                INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
                                WHERE r.categoria = '$categoria'";
    $result_recetas = mysqli_query($conexion, $query_recetas_categoria);
} else {
    echo "Categoría no especificada.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas de <?php echo $categoria; ?></title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/estilo.recetas.css">
    <style>
        /* Aseguramos que el footer siempre esté al fondo de la página */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column; /* Usamos flex para asegurar que el contenido se expanda */
        }

        .container {
            flex: 1; /* Deja que el contenido se expanda para llenar el espacio restante */
            padding-bottom: 50px; /* Esto asegura que el contenido no quede debajo del footer */
        }

        /* Navbar */
        .navbar {
            z-index: 1000; /* Asegura que la navbar se quede encima del contenido */
        }

        /* Navbar links */
        .navbar-light .navbar-nav .nav-link {
            color: #333 !important; /* Asegura que los enlaces se vean correctamente */
        }

        footer {
            width: 100%;
            padding: 20px 0;
        }

        footer .social-icons img {
            max-width: 30px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <!-- Navegación -->
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

    <!-- Título de la página de categoría -->
    <section class="container my-5">
        <h2 class="mb-4">Recetas de <?php echo $categoria; ?></h2>
        <div class="row">
            <?php while ($receta = mysqli_fetch_assoc($result_recetas)) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <a href="/Blog.cocina/vistas/PlantillaRegistro.php?id_receta=<?php echo $receta['id_receta']; ?>">
                            <img src="<?php echo $receta['ruta_imagen']; ?>" class="card-img-top" alt="<?php echo $receta['titulo']; ?>" style="height: 300px; object-fit: cover;">
                        </a>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $receta['titulo']; ?></h5>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <!-- Pie de página -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
        <p>Síguenos en nuestras redes sociales</p>
        <div class="social-icons">
            <img src="..\assets\images\imagenes\Iconos\face.png" alt="Facebook">
            <img src="..\assets\images\imagenes\Iconos\insta.png" alt="Instagram">
            <img src="..\assets\images\imagenes\Iconos\twitter.png" alt="YouTube">
        </div>
    </footer>
</body>
</html>
