<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>
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
    include '../config/Conexion.php'; 

    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtener el id_receta de la URL
    if (isset($_GET['id_receta'])) {
        $id_receta = intval($_GET['id_receta']); // Convertir el id a un valor entero
    } else {
        // Si no se pasa id_receta, redirigir a la página principal
        header('Location: index.php');
        exit();
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

    <section class="container my-5">
        <?php
        // Consulta para obtener solo la receta seleccionada con su imagen
        $sql = "
            SELECT r.id_receta, r.titulo, i.ruta_imagen 
            FROM recetas AS r
            INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
            WHERE r.id_receta = $id_receta
        ";
        $result = $conn->query($sql);

        // Verificar que la consulta se ejecutó correctamente
        if ($result === false) {
            die("Error en la consulta de recetas: " . $conn->error);
        }

        // Comprobar si la receta está disponible
        if ($result->num_rows > 0) {
            // Mostrar la receta seleccionada
            $row = $result->fetch_assoc();
            echo "<h2>" . htmlspecialchars($row["titulo"]) . "</h2>"; 
            echo "<img src='" . htmlspecialchars($row["ruta_imagen"]) . "' alt='Imagen de " . htmlspecialchars($row["titulo"]) . "' class='img-fluid mb-3'>";
            echo "<h4>Ingredientes:</h4><ul>";

            // Consulta para obtener los ingredientes de la receta seleccionada
            $sql_ingredientes = "SELECT i.nombre_ingrediente 
                                 FROM receta_ingredientes ri 
                                 JOIN ingredientes i ON ri.id_ingrediente = i.id_ingrediente 
                                 WHERE ri.id_receta = $id_receta";

            $result_ingredientes = $conn->query($sql_ingredientes);

            // Verificar que la consulta de ingredientes se ejecutó correctamente
            if ($result_ingredientes === false) {
                die("Error en la consulta de ingredientes: " . $conn->error);
            }

            // Mostrar ingredientes
            while ($ingrediente = $result_ingredientes->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($ingrediente["nombre_ingrediente"]) . "</li>";
            }

            echo "</ul><h4>Pasos:</h4><ol>";

            // Asumimos que el campo "pasos" tiene un texto con los pasos
            if (isset($row["pasos"])) {
                echo "<li>" . htmlspecialchars($row["pasos"]) . "</li>";
            } else {
                echo "<li>No se han especificado pasos para esta receta.</li>";
            }

            echo "</ol><hr>";
        } else {
            echo "<p>No hay detalles disponibles para esta receta.</p>";
        }
        ?>
        <a href="index.php" class="btn btn-primary">Volver a la página principal</a>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
