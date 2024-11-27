<?php
session_start();
require_once '../config/Conexion.php'; // Asegúrate de que el archivo exista y tenga conexión válida.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Obtén los datos enviados desde el formulario
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Validación básica
    if (empty($usuario) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        // Preparar consulta para buscar el usuario
        $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, password, id_rol FROM usuarios WHERE nombre_usuario = ?");
        if ($stmt) {
            $stmt->bind_param('s', $usuario);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $fila = $resultado->fetch_assoc();

                // Verificar la contraseña (texto plano)
                if ($password === $fila['password']) {
                    // Guardar datos en la sesión
                    $_SESSION['id_usuario'] = $fila['id_usuario'];
                    $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];
                    $_SESSION['id_rol'] = $fila['id_rol'];

                    // Redirigir al dashboard
                    header('Location: index.php');
                    exit();
                } else {
                    $error = "Contraseña incorrecta.";
                }
            } else {
                $error = "Usuario no encontrado.";
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
    <title>Login</title>
    <link rel="stylesheet" href="..\assets\librerias\estilos_crud.css">
</head>
<body>
    <h2>Login</h2>
    <form method="POST" action="">
        <label for="usuario">Usuario:</label>
        <input type="text" name="usuario" required>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" required>

        <button type="submit" name="login">Iniciar Sesión</button>
    </form>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
</body>
</html>
