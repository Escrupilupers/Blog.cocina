<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Cocinar</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\assets\styless.css">
</head>
<body>
    <?php
    // Conexión a la base de datos
    include '../config/Conexion.php';

    // Consulta para obtener las imágenes y los títulos de las recetas con IDs específicos
    $query_imagenes_especificas = "
        SELECT r.id_receta, r.titulo, i.ruta_imagen 
        FROM recetas AS r
        INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
        WHERE r.id_receta IN (10, 11)
    ";
    $result_imagenes_especificas = mysqli_query($conexion, $query_imagenes_especificas);
    
    // Crear un array para almacenar las rutas de las imágenes y los títulos de recetas específicas
    $imagenes_especificas = [];
    while ($row = mysqli_fetch_assoc($result_imagenes_especificas)) {
        $imagenes_especificas[$row['id_receta']] = [
            'titulo' => $row['titulo'],   // Guardamos el título de la receta
            'ruta_imagen' => $row['ruta_imagen']   // Guardamos la ruta de la imagen
        ];
    }
    ?>

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

    <!-- Hero Section -->
    <section class="hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-4 fw-bold">¡Bienvenido al Paraíso Culinario!</h1>
                </div>
                <div class="col-md-6 text-end">
                    <p>Únate en un viaje gastronómico donde cada plato contiene una historia y cada receta es una sinfonía de sabor elaborada. En donde aprenderán a elaborar recetas complicadas como fáciles. Demostrando que no es necesario ser un chef para despertar tus dotes culinarios.</p>
                    <a href="plantilla.php" class="btn btn-warning">Explorar Recetas</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Historia -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <h2>De las raíces italianas a los paladares globales</h2>
                <p>Nos interesamos por mostrar las diferentes culturas culinarias, por eso mostramos la breve historia de una increíble chef. Así como sus historias, contaremos muchas más.</p>
                <p>Nacida y criada en el vibrante paisaje culinario de Italia, mi viaje con la comida comenzó en el corazón de la cocina de mi familia. Rodeada por el aroma de las hierbas frescas, el chisporroteo de las sartenes y las risas de mis seres queridos, desarrollé un profundo aprecio por el arte de cocinar.</p>
            </div>
            <div class="col-md-6">
                <img src="https://i.pinimg.com/originals/c9/14/fd/c914fd66f82ff5857deb39d9f9159c20.jpg" alt="Chef" class="img-fluid rounded">
            </div>
        </div>
    </section>

    <!-- Galería de imágenes -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <img src="https://cdn.nutritionstudies.org/wp-content/uploads/2018/01/top-15-spices-plant-based-cooking-1024x536.jpg" class="img-fluid rounded mb-3" alt="Entendiendo las especias">
            </div>
            <div class="col-md-3">
                <img src="https://www.cocinaconalegria.com/wp-content/uploads/2022/05/aprendiendo-a-comprar-almacenar-y-cocinar-por-grupo-de-alimentos-primera-parte-las-verduras-y-las-frutas.jpg" class="img-fluid rounded mb-3" alt="Elegir productos">
            </div>
            <div class="col-md-3">
                <img src="https://i.blogs.es/79001c/foto-diferencias/450_1000.jpg" class="img-fluid rounded mb-3" alt="Hierbas frescas versus secas">
            </div>
            <div class="col-md-3">
                <img src="https://img.freepik.com/fotos-premium/cocina-basada-plantas-nuestra-fotografia-comida-vegana-vegetales-asados-libro-cocina-menu_763042-2002.jpg" class="img-fluid rounded mb-3" alt="Cocina basada en plantas">
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <img src="https://www.caixabanklab.com/elbullifoundation/wp-content/uploads/sites/2/2019/07/caracteristicas-generales-cocina-1140x759.jpg" class="img-fluid rounded mb-3" alt="Estaciones de trabajo de preparación">
            </div>
            <div class="col-md-3">
                <img src="https://i0.wp.com/comedores-industriales.com.mx/wp-content/uploads/2020/04/lavado-de-cocina.jpg?fit=820%2C513&ssl=1" class="img-fluid rounded mb-3" alt="Limpiar sobre la marcha">
            </div>
            <div class="col-md-3">
                <img src="https://assets.tmecosys.com/image/upload/t_web767x639/img/recipe/ras/Assets/68c7450e-6579-402a-a8e0-5f7c5a1a01d5/Derivates/4bbcb8e7-e9da-45d0-9000-abd23e19d112.jpg" class="img-fluid rounded mb-3" alt="Mousse de Chocolate Decadente">
            </div>
            <div class="col-md-3">
                <img src="https://img.freepik.com/fotos-premium/pollo-asado-crujiente-infundido-hierbas-aromaticas_167857-48341.jpg" class="img-fluid rounded mb-3" alt="Pollo Salado con Infusión de Hierbas">
            </div>
        </div>
    </section>

    <!-- Recetas Populares -->
    <section class="container my-5">
        <h1 class="text-center">Nuestros favoritos</h1>
        <p class="text-center">Explora las sigueintes recetas favoritas de los creadores</p>

              <div class="row">
        <div class="row">
    <?php foreach ($imagenes_especificas as $id_receta => $datos): ?>
        <div class="col-md-6 mb-4">
            <a href="PlantillaRegistro.php?id_receta=<?php echo $id_receta; ?>" class="text-decoration-none">
                <div class="card">
                    <img src="<?php echo $datos['ruta_imagen']; ?>" class="card-img-top" alt="Receta <?php echo $id_receta; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $datos['titulo']; ?></h5>
                    </div>
                </div>
            </a>
        </div>
    <?php endforeach; ?>
    </section>


    <!-- Sección de Suscripción -->
    <section class="suscripcion text-center py-5">
        <div class="container">
            <h2 class="text-white">SUSCRÍBETE AHORA</h2>
            <p class="text-white">Suscríbete a nuestro boletín para recibir una porción semanal de recetas, consejos de cocina e información exclusiva directamente en su bandeja de entrada</p>
            <form class="d-flex justify-content-center">
                <input type="email" class="form-control w-50" placeholder="Correo Electrónico">
                <button type="submit" class="btn btn-dark ms-2">SUBSCRÍBETE</button>
            </form>
        </div>
    </section>

    <!-- Footer -->
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
