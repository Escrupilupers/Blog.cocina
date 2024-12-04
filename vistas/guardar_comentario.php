<?php
include '../config/Conexion.php';

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario
    $id_receta = intval($_POST['id_receta']);
    $nombre = $conn->real_escape_string($_POST['name']);
    $correo = $conn->real_escape_string($_POST['email']);
    $comentario = $conn->real_escape_string($_POST['comment']);
    
    // Insertamos el comentario en la base de datos
    $sql_comentario = "
        INSERT INTO comentarios (id_receta, nombre, correo, comentario, fecha) 
        VALUES ('$id_receta', '$nombre', '$correo', '$comentario', NOW())
    ";

    if ($conn->query($sql_comentario) === TRUE) {
        // Si la inserción fue exitosa, redirigimos a la página de la receta
        header("Location: plantillaRegistro.php?id_receta=$id_receta");
        exit();
    } else {
        echo "Error al guardar el comentario: " . $conn->error;
    }
}
?>