<?php
require "../config/Conexion.php";

// Consulta para unir recetas con sus imágenes
$query = "
    SELECT r.id_receta, r.titulo, r.categoria, i.ruta_imagen 
    FROM recetas AS r
    INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
";
$result = mysqli_query($conexion, $query);

// Consulta para obtener las categorías dinámicamente
$query_categorias = "SELECT DISTINCT categoria FROM recetas";
$result_categorias = mysqli_query($conexion, $query_categorias);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
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

    <!-- Sección Explora la Variedad -->
    <div class="row mx-3">
        <div class="col-md-1"></div>
        <div class="col-md-11 turquoise-box">
            <div class="row">
                <div class="col-md-6">
                    <h3>Explora la variedad</h3>
                    <p>Si es un entusiasta del desayuno, un conocedor de delicias saladas o busca postres irresistibles, nuestra cuidada selección tiene algo para satisfacer todos los paladares.</p>
                </div>
                <div class="col-md-6 icon-center"></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="row">
                        <?php while ($categoria = mysqli_fetch_assoc($result_categorias)) { ?>
                            <div class="col-md-2 text-center">
                                <a href="recetas_categoria.php?categoria=<?php echo $categoria['categoria']; ?>">
                                    <img src="../assets/images/imagenes/Iconos/<?php echo strtolower($categoria['categoria']); ?>.png" alt="<?php echo $categoria['categoria']; ?>" style="max-width: 30px;">
                                    <br><?php echo $categoria['categoria']; ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recetas Populares -->
    <section class="container my-5">
        <h2 class="mb-4">Recetas Populares</h2>
        <div class="row">
            <?php while ($text = mysqli_fetch_assoc($result)) { ?>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
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
            <img src="..\assets\images\imagenes\Iconos\face.png" alt="Facebook">
            <img src="..\assets\images\imagenes\Iconos\insta.png" alt="Instagram">
            <img src="..\assets\images\imagenes\Iconos\twitter.png" alt="YouTube">
        </div>
    </footer>
</body>
</html>
