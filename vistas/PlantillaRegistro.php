<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recetas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <?php 
    include 'C:\xampp\htdocs\blog.cocina\ajax\php del html\conexion.php'; 
    
    // Verificar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
    ?>

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light rounded-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">A Cocinar</a>
        </div>
    </nav>

    <section class="container my-5">
        <?php
        // Consulta para obtener solo la primera receta
        $sql = "SELECT * FROM recetas LIMIT 1";
        $result = $conn->query($sql);

        // Verificar que la consulta se ejecutó correctamente
        if ($result === false) {
            die("Error en la consulta de recetas: " . $conn->error);
        }

        // Comprobar si hay recetas disponibles
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<h2>" . htmlspecialchars($row["titulo"]) . "</h2>"; // Usamos el campo 'titulo' en lugar de 'nombre'
                echo "<h4>Ingredientes:</h4><ul>";

                // Consulta para obtener los ingredientes de la receta
                $sql_ingredientes = "SELECT i.nombre_ingrediente 
                                     FROM receta_ingredientes ri 
                                     JOIN ingredientes i ON ri.id_ingrediente = i.id_ingrediente 
                                     WHERE ri.id_receta = " . intval($row["id_receta"]);

                $result_ingredientes = $conn->query($sql_ingredientes);

                // Verificar que la consulta de ingredientes se ejecutó correctamente
                if ($result_ingredientes === false) {
                    die("Error en la consulta de ingredientes: " . $conn->error);
                }

                // Mostrar ingredientes
                while($ingrediente = $result_ingredientes->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($ingrediente["nombre_ingrediente"]) . "</li>";
                }

                echo "</ul><h4>Pasos:</h4><ol>";

                // Asumimos que el campo "pasos" tiene un texto con los pasos (esto puede ajustarse si el formato es diferente)
                if (isset($row["pasos"])) {
                    echo "<li>" . htmlspecialchars($row["pasos"]) . "</li>";
                } else {
                    echo "<li>No se han especificado pasos para esta receta.</li>";
                }

                echo "</ol><hr>";
            }
        } else {
            echo "<p>No hay recetas disponibles.</p>";
        }
        ?>
        <a href="index.php" class="btn btn-primary">Volver a la página principal</a>
    </section>

</body>
</html>
