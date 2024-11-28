<?php
session_start();
require_once '../config/Conexion.php'; // Asegúrate de que el archivo exista y tenga conexión válida.

// Variables de error
$error = "";

// Lógica de Login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    // Obtén los datos enviados desde el formulario de login
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);

    // Validación básica de login
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

                // Verificar la contraseña (sin hash, comparación directa)
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

// Lógica de Registro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registrarse'])) {
    // Obtener los datos enviados desde el formulario de registro
    $nuevo_usuario = trim($_POST['nuevo_usuario']);
    $correo = trim($_POST['correo']);
    $nueva_password = trim($_POST['nueva_password']);
    $puntos = 0; // Puntos iniciales para el nuevo usuario
    $id_rol = 2; // Asumiendo que 2 es el rol de usuario normal (puedes ajustarlo según tu lógica)

    // Validación básica de registro
    if (empty($nuevo_usuario) || empty($correo) || empty($nueva_password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        // Preparar la consulta para insertar el nuevo usuario
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo, puntos, id_rol, password) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param('ssiss', $nuevo_usuario, $correo, $puntos, $id_rol, $nueva_password);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Redirigir al login después del registro
                header('Location: login.php'); // Redirigir al login
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
    <title>Login / Registro</title>
    <link rel="stylesheet" href="..\assets\librerias\estilos_crud.css">
    <style>
        .registro-form {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            margin-top: 20px;
        }
        .login-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h2>Login</h2>

    <!-- Formulario de Login -->
    <div id="loginForm" class="login-form">
        <form method="POST" action="">
            <label for="usuario">Usuario:</label>
            <input type="text" name="usuario" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Iniciar Sesión</button>
            
            <p>¿No tienes cuenta? <a href="javascript:void(0);" class="registro-link" onclick="mostrarFormulario()">Regístrate aquí</a></p>
        </form>
    </div>

    <!-- Formulario de Registro oculto inicialmente -->
    <div id="formularioRegistro" class="registro-form">
        <h3>Crear Cuenta</h3>
        <form method="POST" action="">
            <label for="nuevo_usuario">Nuevo Usuario:</label>
            <input type="text" name="nuevo_usuario" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" name="correo" required>

            <label for="nueva_password">Contraseña:</label>
            <input type="password" name="nueva_password" required>

            <button type="submit" name="registrarse">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="javascript:void(0);" class="registro-link" onclick="mostrarLogin()">Inicia sesión aquí</a></p>
    </div>

    <?php if (!empty($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <script>
        // Función para mostrar el formulario de registro y ocultar el de login
        function mostrarFormulario() {
            var loginForm = document.getElementById('loginForm');
            var registroForm = document.getElementById('formularioRegistro');

            // Ocultar formulario de login
            loginForm.style.display = 'none';

            // Mostrar formulario de registro con efecto de desvanecimiento
            registroForm.style.display = 'block';
            setTimeout(function() {
                registroForm.style.opacity = 1; // Desvanecer el formulario
            }, 10);
        }

        // Función para mostrar el formulario de login y ocultar el de registro
        function mostrarLogin() {
            var loginForm = document.getElementById('loginForm');
            var registroForm = document.getElementById('formularioRegistro');

            // Ocultar formulario de registro
            registroForm.style.display = 'none';

            // Mostrar formulario de login
            loginForm.style.display = 'block';
        }
    </script>
</body>
</html>
