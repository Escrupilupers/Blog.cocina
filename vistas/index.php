<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetario</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/styles.css">
    <style>
        .img-fluid, .img-thumbnail {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .trend-recipes img {
            width: 50px;
            height: 50px;
        }
    </style>    
</head>
<body>
    <?php
    // Conexión a la base de datos
    include '../config/Conexion.php';

    // Consulta para obtener las imágenes de las recetas con IDs específicos
    $query_imagenes_especificas = "
        SELECT r.id_receta, i.ruta_imagen 
        FROM recetas AS r
        INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
        WHERE r.id_receta IN (6, 7, 8, 9)
    ";
    $result_imagenes_especificas = mysqli_query($conexion, $query_imagenes_especificas);

    // Crear un array para almacenar las rutas de las imágenes de recetas específicas
    $imagenes_especificas = [];
    while ($row = mysqli_fetch_assoc($result_imagenes_especificas)) {
        $imagenes_especificas[$row['id_receta']] = $row['ruta_imagen'];
    }

    // Consulta para obtener las imágenes de las últimas recetas (3 más recientes)
    $query_ultimas_recetas = "
        SELECT r.id_receta, r.titulo, i.ruta_imagen
        FROM recetas AS r
        INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
        ORDER BY r.id_receta DESC
        LIMIT 3
    ";
    $result_ultimas_recetas = mysqli_query($conexion, $query_ultimas_recetas);

    // Crear un array para almacenar las rutas de las imágenes de las últimas recetas
    $ultimas_recetas = [];
    while ($row = mysqli_fetch_assoc($result_ultimas_recetas)) {
        $ultimas_recetas[] = $row;
    }

    // Consulta para obtener las primeras 4 recetas (recetas en tendencia)
    $query_recetas_tendencia = "
        SELECT r.id_receta, r.titulo, i.ruta_imagen
        FROM recetas AS r
        INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
        ORDER BY r.id_receta ASC
        LIMIT 4
    ";
    $result_recetas_tendencia = mysqli_query($conexion, $query_recetas_tendencia);

    // Crear un array para almacenar las rutas de las imágenes de las recetas en tendencia
    $recetas_tendencia = [];
    while ($row = mysqli_fetch_assoc($result_recetas_tendencia)) {
        $recetas_tendencia[] = $row;
    }
    ?>

    <!-- Nueva Navegación -->
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

    <!-- Contenedor con imagen de fondo -->
    <div class="bg-image" style="background-image: url('https://wallpapers.com/images/hd/food-4k-1pf6px6ryqfjtnyr.jpg'); height: 100vh;">
        <div class="mask p-2">
            <div class="container text-center" style="position: relative; z-index: 5;">
                <h1 class="text-white md-5">Libera la excelencia culinaria</h1>
                <button class="btn btn-danger md-3">Ver Recetas</button>
            </div>
        </div>
    </div>

    <!-- Galería de imágenes flotantes entre contenedores -->
    <div class="image-gallery text-center">
        <?php foreach ($imagenes_especificas as $id_receta => $ruta_imagen): ?>
            <a href="PlantillaRegistro.php?id_receta=<?php echo $id_receta; ?>">
                <img src="<?php echo $ruta_imagen; ?>" alt="Receta <?php echo $id_receta; ?>" class="img-fluid">
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Sección principal con Últimas Recetas y Recetas en Tendencia -->
    <div class="container md-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="text-center">Últimas Recetas</h2>
                <div class="row">
                    <?php foreach ($ultimas_recetas as $receta): ?>
                        <div class="col-md-4">
                            <a href="PlantillaRegistro.php?id_receta=<?php echo $receta['id_receta']; ?>">
                                <img src="<?php echo $receta['ruta_imagen']; ?>" class="img-fluid rounded" alt="Última receta <?php echo $receta['titulo']; ?>">
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="updates-container">
                    <div class="mask-gray p-3 rounded">
                        <h4 class="text-center">Actualizaciones</h4>
                        <input type="email" class="form-control" placeholder="Correo">
                        <button class="btn btn-danger md-2">Suscríbete</button>
                    </div>
                </div>

                <div class="trend-container md-4">
                    <div class="mask-gray p-3 rounded">
                        <h2 class="text-center">Recetas en Tendencia</h2>
                        <div class="trend-recipes d-flex justify-content-center md-3">
                            <?php foreach ($recetas_tendencia as $receta): ?>
                                <a href="PlantillaRegistro.php?id_receta=<?php echo $receta['id_receta']; ?>">
                                    <img src="<?php echo $receta['ruta_imagen']; ?>" class="img-thumbnail" alt="Tendencia <?php echo $receta['titulo']; ?>">
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
