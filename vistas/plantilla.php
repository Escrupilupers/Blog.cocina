<?php
require "../config/Conexion.php";

// Consulta para unir recetas con sus imágenes
$query = "
    SELECT r.id_receta, r.titulo, r.categoria, i.ruta_imagen 
    FROM recetas AS r
    INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
";
$result = mysqli_query($conexion, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/blog.cocina/assets/style.css">
</head>
<body>
    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">A Cocinar</a>
        </div>
    </nav>

    <section class="container my-5">
        <h2 class="mb-4">Recetas Populares</h2>
        <div class="row">
            <?php foreach ($result as $text) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <!-- Envolvemos la imagen con un enlace para redirigir a la primera plantilla -->
                        <a href="/Blog.cocina/vistas/PlantillaRegistro.php?id_receta=<?php echo $text['id_receta']; ?>">
    <img src="<?php echo $text['ruta_imagen']; ?>" class="card-img-top" alt="<?php echo $text['categoria']; ?>" style="height: 300px; object-fit: cover;">
</a>

                        <div class="card-body">
                            <h5 class="card-title"><?php echo $text['titulo']; ?></h5>
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
            <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram">
            <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" alt="YouTube">
        </div>
    </footer>
</body>
</html>
