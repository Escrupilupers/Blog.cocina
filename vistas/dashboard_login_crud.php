<?php
session_start();
require_once '../config/Conexion.php'; // Asegúrate de que el archivo tenga la conexión correcta.

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta ajustada para reflejar los campos de tu tabla
    $stmt = $conn->prepare("SELECT id_usuario, nombre_usuario, password, id_rol FROM usuarios WHERE nombre_usuario = ?");
    if (!$stmt) {
        die("Error en la consulta SQL: " . $conn->error);
    }
    
    $stmt->bind_param('s', $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $fila['password'])) {
            // Guardar información del usuario en la sesión
            $_SESSION['id_usuario'] = $fila['id_usuario'];
            $_SESSION['nombre_usuario'] = $fila['nombre_usuario'];
            $_SESSION['id_rol'] = $fila['id_rol'];

            // Redirigir según el rol
            if ($fila['id_rol'] == 1) {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: user_dashboard.php');
            }
            exit();
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <?php if (!isset($_SESSION['usuario'])): ?>
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Iniciar Sesión</button>
        </form>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <?php else: ?>
        <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></h2>
        <a href="?logout=true">Cerrar Sesión</a>
    <?php endif; ?>
</body>
</html>