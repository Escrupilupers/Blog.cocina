<?php
session_start();
require_once '../config/Conexion.php'; // Asegúrate de que el archivo exista y tenga conexión válida.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrarse'])) {
    // Obtener los datos enviados desde el formulario
    $nuevo_usuario = trim($_POST['nuevo_usuario']);
    $nueva_password = trim($_POST['nueva_password']);

    // Validación básica
    if (empty($nuevo_usuario) || empty($nueva_password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        // Encriptar la contraseña antes de almacenarla (usar hash seguro)
        $hashed_password = password_hash($nueva_password, PASSWORD_BCRYPT);

        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, password) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param('ss', $nuevo_usuario, $hashed_password);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir al login o a una página de éxito
                header('Location: ..\controlador\login.php'); // Cambiar por la ruta de tu login
                exit();
            } else {
                $error = "Error al registrar el usuario: " . $stmt->error;
            }
        } else {
            $error = "Error al preparar la consulta: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
</head>
<body>
    <h2>Registrar Usuario</h2>
    <form method="POST" action="registro.php">
        <label for="nuevo_usuario">Nuevo Usuario:</label>
        <input type="text" name="nuevo_usuario" required>

        <label for="nueva_password">Contraseña:</label>
        <input type="password" name="nueva_password" required>

        <button type="submit" name="registrarse">Registrarse</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
