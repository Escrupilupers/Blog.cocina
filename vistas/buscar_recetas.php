<?php
// Conexión a la base de datos
include '../config/Conexion.php';

// Inicializar variables
$titulo = '';
$resultado_busqueda = [];

if (isset($_GET['titulo'])) {
    // Obtener el título desde el formulario de búsqueda
    $titulo = mysqli_real_escape_string($conexion, $_GET['titulo']);
    
    // Consulta para buscar recetas que coincidan con el título
    $sql = "SELECT r.id_receta, r.titulo, r.descripcion, i.ruta_imagen 
            FROM recetas AS r
            INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
            WHERE r.titulo LIKE '%$titulo%'";
    
    $resultado_busqueda = mysqli_query($conexion, $sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de búsqueda</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">A Cocinar</a>
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
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Resultados de búsqueda para: <?php echo htmlspecialchars($titulo); ?></h2>

        <?php if (mysqli_num_rows($resultado_busqueda) > 0): ?>
            <div class="row">
                <?php while ($row = mysqli_fetch_assoc($resultado_busqueda)): ?>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="<?php echo $row['ruta_imagen']; ?>" class="card-img-top" alt="Imagen receta">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                                <p class="card-text"><?php echo substr($row['descripcion'], 0, 100) . '...'; ?></p>
                                <a href="PlantillaRegistro.php?id_receta=<?php echo $row['id_receta']; ?>" class="btn btn-primary">Ver receta</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No se encontraron resultados para "<?php echo htmlspecialchars($titulo); ?>".</p>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
        <p>Síguenos en nuestras redes sociales</p>
        <div class="social-icons">
            <img src="..\assets\images\imagenes\Iconos\face.png" alt="Facebook">
            <img src="..\assets\images\imagenes\Iconos\insta.png" alt="Instagram">
            <img src="..\assets\images\imagenes\Iconos\twitter.png" alt="YouTube">
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
