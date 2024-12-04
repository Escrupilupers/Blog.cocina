<?php
include '../config/Conexion.php';
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_GET['id_receta'])) {
    header('Location: index.php');
    exit();
}

$id_receta = intval($_GET['id_receta']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Comentario</title>
    <link href="../assets/librerias/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar un comentario</h2>
        <form action="guardar_comentario.php" method="POST">
            <input type="hidden" name="id_receta" value="<?php echo $id_receta; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="comment" class="form-label">Comentario</label>
                <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enviar Comentario</button>
            <a href="PlantillaRegistro.php?id_receta=<?php echo $id_receta; ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>
