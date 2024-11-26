<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A Cocinar</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="..\assets\estilo.css">
    <style>
        .card-img-top {
            width: 100%;
            height: 200px; /* Ajusta el tamaño de las imágenes */
            object-fit: cover;
        }

        .social-icons img {
            width: 30px;
            height: 30px;
            object-fit: contain;
            margin-left: 10px;
        }
    </style>
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

    <!-- Contenido principal -->
    <section class="container my-5">
        <h1 class="text-center">Nuestros Consejos de Cocina Esenciales</h1>
        <p class="text-center">¡Bienvenido al tesoro de sabiduría culinaria de Cooks Delight! Ya sea que seas un chef experimentado o recién estés comenzando, nuestros consejos de cocina están diseñados para mejorar tus habilidades.</p>

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
</div>
  <!-- Recetas populares -->

        <!-- Dominando los conceptos básicos -->
        <h2 class="my-4">Dominando los Conceptos Básicos</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://img.freepik.com/fotos-premium/habilidades-cuchillo-perfeccionadas-leccion-cocina-cajun-ar-generativo-ai_1169639-112055.jpg" class="card-img-top" alt="Habilidades con el cuchillo">
                    <div class="card-body">
                        <h5 class="card-title">Habilidades con el cuchillo</h5>
                        <p class="card-text">Desbloquea el arte de la precisión con técnicas adecuadas para picar, cortar en cubitos y rebanar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://recetasdecocina.elmundo.es/wp-content/uploads/2023/02/que-es-saltear-cocina.jpg" class="card-img-top" alt="Saltear y dorar">
                    <div class="card-body">
                        <h5 class="card-title">Saltear y dorar</h5>
                        <p class="card-text">Aprende los secretos para saltear como un profesional y crear texturas irresistibles.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://www.cucinare.tv/wp-content/uploads/2019/08/Preparando-el-asado.jpg" class="card-img-top" alt="Consejos para asar">
                    <div class="card-body">
                        <h5 class="card-title">Consejos para asar</h5>
                        <p class="card-text">Garantiza una cocción uniforme y sabrosa con nuestros consejos de asado.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://blogs.unitec.mx/hubfs/Imported_Blog_Media/estaciones-de-trabajo-cocina-profesional-2-Dec-17-2022-07-23-41-8269-PM.jpg" class="card-img-top" alt="Estaciones de trabajo de preparación">
                    <div class="card-body">
                        <h5 class="card-title">Estaciones de trabajo de preparación</h5>
                        <p class="card-text">Organice eficientemente el espacio de su cocina para picar, mezclar y cocinar.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://uvn-brightspot.s3.amazonaws.com/assets/vixes/imj/hogartotal/g/guia-rapida-para-limpiar-todo-tipo-de-superficies-en-la-cocina-1.jpg" class="card-img-top" alt="Limpiar sobre la marcha">
                    <div class="card-body">
                        <h5 class="card-title">Limpiar sobre la marcha</h5>
                        <p class="card-text">Mantén tu cocina ordenada y eficiente mientras cocinas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://m.media-amazon.com/images/I/C1kIkh-zKCL._CR0,0,4032,2275_SR684,386_.jpg" class="card-img-top" alt="Modificación de receta">
                    <div class="card-body">
                        <h5 class="card-title">Modificación de receta</h5>
                        <p class="card-text">Explora la creatividad culinaria modificando recetas a tu estilo.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Nutriendo cada paladar -->
        <h2 class="my-4">Nutriendo cada paladar</h2>
        <div class="row bg-light p-4 rounded-3">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://media.istockphoto.com/id/1144977508/photo/gluten-free-diet-concept-selection-of-grains-and-carbohydrates-for-people-with-gluten.jpg?s=612x612&w=0&k=20&c=jeDGc2K8DconHlZ0NryCh2r7A0vJGvfCmzu24-fFuZs=" class="card-img-top" alt="Alternativas sin gluten">
                    <div class="card-body">
                        <h5 class="card-title">Alternativas sin gluten</h5>
                        <p class="card-text">Explore el mundo de las harinas y los cereales sin gluten para crear platos deliciosos.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://img.freepik.com/fotos-premium/cocina-basada-plantas-nuestra-fotografia-comida-vegana-vegetales-asados-libro-cocina-menu_763042-2002.jpg" class="card-img-top" alt="Cocina basada en plantas">
                    <div class="card-body">
                        <h5 class="card-title">Cocina basada en plantas</h5>
                        <p class="card-text">Aprenda cómo crear platos sustanciosos y llenos de sabor sin productos animales.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="https://hoy.com.do/wp-content/uploads/2014/11/recetas-balanceadas.jpg" class="card-img-top" alt="Comida balanceada">
                    <div class="card-body">
                        <h5 class="card-title">Comida balanceada</h5>
                        <p class="card-text">Consejos para equilibrar nutrientes en todas tus comidas.</p>
                    </div>
                </div>
            </div>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>