<?php
include '../config/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receta_id = $_POST['receta_id'];
    $nombre = $_POST['nombre'];
    $pasos = $_POST['pasos'];
    $ingredientes = $_POST['ingredientes'];

    // Actualizar receta
    $sql = "UPDATE recetas SET nombre='$nombre', pasos='$pasos' WHERE id=$receta_id";
    $conn->query($sql);

    // Actualizar ingredientes
    $conn->query("DELETE FROM receta_ingredientes WHERE receta_id = $receta_id");
    foreach ($ingredientes as $nombre_ingrediente) {
        $sql = "INSERT INTO ingredientes (nombre) VALUES ('$nombre_ingrediente') ON DUPLICATE KEY UPDATE nombre = nombre";
        $conn->query($sql);

        $ingrediente_id = $conn->insert_id;
        $conn->query("INSERT INTO receta_ingredientes (receta_id, ingrediente_id) VALUES ($receta_id, $ingrediente_id)");
    }

    header("Location: editar_receta.php");
    exit();
}
?>
