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

        .rating {
            display: flex;
            gap: 5px;
            align-items: center;
            font-size: 1.5rem;
            color: gold;
        }

        .star {
            cursor: pointer;
        }

        .star.filled {
            color: gold;
        }

        .star.unfilled {
            color: gray;
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
        header('Location: index.php');
        exit();
    }

    // Suponiendo que el usuario ya ha iniciado sesión
    $id_usuario = 1; // Reemplazar con el ID del usuario autenticado
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
        // Obtener receta y su imagen
        $sql = "
            SELECT r.id_receta, r.titulo, i.ruta_imagen 
            FROM recetas AS r
            INNER JOIN imagenes AS i ON r.id_imagen = i.id_imagen
            WHERE r.id_receta = $id_receta
        ";
        $result = $conn->query($sql);
        if ($result === false) {
            die("Error en la consulta de recetas: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h2>" . htmlspecialchars($row["titulo"]) . "</h2>"; 
            echo "<img src='" . htmlspecialchars($row["ruta_imagen"]) . "' alt='Imagen de " . htmlspecialchars($row["titulo"]) . "' class='img-fluid mb-3'>";

            // Ingredientes
            $sql_ingredientes = "
                SELECT i.nombre_ingrediente 
                FROM receta_ingredientes ri 
                JOIN ingredientes i ON ri.id_ingrediente = i.id_ingrediente 
                WHERE ri.id_receta = $id_receta";
            $result_ingredientes = $conn->query($sql_ingredientes);
            echo "<h4>Ingredientes:</h4><ul>";
            while ($ingrediente = $result_ingredientes->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($ingrediente["nombre_ingrediente"]) . "</li>";
            }
            echo "</ul>";

            // Calificación promedio
            $sql_valoracion = "
                SELECT AVG(calificacion) AS promedio_calificacion 
                FROM valoraciones 
                WHERE id_receta = $id_receta";
            $result_valoracion = $conn->query($sql_valoracion);
            $promedio_calificacion = 0;
            if ($result_valoracion && $result_valoracion->num_rows > 0) {
                $row_valoracion = $result_valoracion->fetch_assoc();
                $promedio_calificacion = round($row_valoracion['promedio_calificacion']);
            }

            // Mostrar estrellas y permitir interacción
            echo "<h4>Calificación promedio:</h4>";
            echo "<div class='rating' id='rating-section'>";
            for ($i = 1; $i <= 5; $i++) {
                $filled = $i <= $promedio_calificacion ? "filled" : "unfilled";
                echo "<span class='star $filled' data-value='$i'>&#9733;</span>";
            }
            echo "</div>";
            echo "<p id='rating-message' style='color: green;'></p>";
        } else {
            echo "<p>No hay detalles disponibles para esta receta.</p>";
        }
        ?>
        <a href="index.php" class="btn btn-primary">Volver a la página principal</a>
    </section>

    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const stars = document.querySelectorAll(".star");
            const ratingMessage = document.getElementById("rating-message");
            const idReceta = <?php echo json_encode($id_receta); ?>;

            stars.forEach(star => {
                star.addEventListener("click", () => {
                    const rating = star.getAttribute("data-value");

                    // Visualización de estrellas
                    stars.forEach(s => s.classList.remove("filled", "unfilled"));
                    stars.forEach((s, index) => {
                        s.classList.add(index < rating ? "filled" : "unfilled");
                    });

                    // Enviar calificación al servidor
                    fetch('guardar_calificacion.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ id_receta: idReceta, calificacion: rating })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            ratingMessage.textContent = "¡Gracias por tu calificación!";
                        } else {
                            ratingMessage.textContent = "Error al guardar tu calificación.";
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                        ratingMessage.textContent = "Error al procesar la solicitud.";
                    });
                });
            });
        });
    </script>
</body>
</html>