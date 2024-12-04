<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../config/Conexion.php'; // Asegúrate de que esté correcto.

$id_usuario_session = $_SESSION['id_usuario']; // Obtener el ID del usuario en sesión
$id_rol_session = $_SESSION['id_rol']; // Obtener el rol del usuario en sesión

// CRUD para gestionar usuarios y roles
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        if ($id_rol_session == 1) { // Solo administrador puede crear
            $nombre = $_POST['nombre_usuario'];
            $correo = $_POST['correo'];
            $puntos = $_POST['puntos'];
            $rol = $_POST['id_rol'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO usuarios (nombre_usuario, correo, puntos, id_rol, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param('ssiss', $nombre, $correo, $puntos, $rol, $password);
            $stmt->execute();
        }
    }
    if (isset($_POST['delete'])) {
        $id = $_POST['id_usuario'];
        if ($id_rol_session == 1 || $id == $id_usuario_session) { // Administrador o el propio usuario
            $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }
    if (isset($_POST['update'])) {
        $id = $_POST['id_usuario'];
        if ($id_rol_session == 1 || $id == $id_usuario_session) { // Administrador o el propio usuario
            $nombre = $_POST['nombre_usuario'];
            $correo = $_POST['correo'];
            $puntos = $_POST['puntos'];
            $rol = $_POST['id_rol'];
            $nueva_contrasena = $_POST['nueva_contrasena'];
    
            if (!empty($nueva_contrasena)) {
                // Ahora almacenamos la nueva contraseña en texto plano
                $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, puntos = ?, id_rol = ?, password = ? WHERE id_usuario = ?");
                $stmt->bind_param('ssisss', $nombre, $correo, $puntos, $rol, $nueva_contrasena, $id); // 's' para la contraseña en texto plano
            } else {
                // Si no se proporciona nueva contraseña, solo actualizamos los otros campos
                $stmt = $conn->prepare("UPDATE usuarios SET nombre_usuario = ?, correo = ?, puntos = ?, id_rol = ? WHERE id_usuario = ?");
                $stmt->bind_param('ssisi', $nombre, $correo, $puntos, $rol, $id);
            }
    
            $stmt->execute();
        }
    }
    
    
}

// Obtener todos los usuarios (administrador puede ver todos, usuarios solo su propio perfil)
if ($id_rol_session == 1) {
    $result = $conn->query("SELECT * FROM usuarios");
} else {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
    $stmt->bind_param('i', $id_usuario_session);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/librerias/estilos_crud.css">
</head>
<body>
    <!-- Nueva Navegación -->
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
                    <!-- Nuevo botón para redirigir al Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white" href="..\vistas\dashboard_login_crud.php">Dashboard</a>
                    </li>
                </ul>
                <button class="btn btn-warning ms-3">Subscríbete</button>
            </div>
        </div>
    </nav>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h2>
    <a href="logout.php">Cerrar Sesión</a>
    
    <!-- Menú de navegación -->
    <nav>
        <ul>
            <li><a href="dashboard_login_crud.php">Usuarios</a></li>
            <li><a href="dashboard_recetas_crud.php">Recetas</a></li>
        </ul>
    </nav>

    <h3>Gestión de Usuarios y Roles</h3>
    <form method="POST">
        <?php if ($id_rol_session == 1): ?>
            <label>Nombre:</label>
            <input type="text" name="nombre_usuario" required>
            <label>Correo:</label>
            <input type="email" name="correo" required>
            <label>Puntos:</label>
            <input type="number" name="puntos" required>
            <label>Rol:</label>
            <select name="id_rol" required>
                <option value="1">Administrador</option>
                <option value="2">Usuario</option>
            </select>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit" name="create">Crear Usuario</button>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Puntos</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id_usuario']; ?></td>
            <td><?php echo $row['nombre_usuario']; ?></td>
            <td><?php echo $row['correo']; ?></td>
            <td><?php echo $row['puntos']; ?></td>
            <td><?php echo $row['id_rol'] == 1 ? 'Administrador' : 'Usuario'; ?></td>
            <td>
                <?php if ($id_rol_session == 1 || $id_usuario_session == $row['id_usuario']): ?>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                        <button type="submit" name="delete">Eliminar</button>
                    </form>
                    <form method="POST" style="display:inline-block;">
                        <input type="hidden" name="id_usuario" value="<?php echo $row['id_usuario']; ?>">
                        <input type="text" name="nombre_usuario" value="<?php echo $row['nombre_usuario']; ?>" required>
                        <input type="email" name="correo" value="<?php echo $row['correo']; ?>" required>
                        <input type="number" name="puntos" value="<?php echo $row['puntos']; ?>" required>
                        <select name="id_rol" required>
                            <?php if ($row['id_rol'] == 1): ?>
                                <option value="1" selected>Administrador</option>
                            <?php else: ?>
                                <option value="2" selected>Usuario</option>
                            <?php endif; ?>
                        </select>
                        <!-- Campo para editar la contraseña -->
                        <input type="password" name="nueva_contrasena" placeholder="Nueva contraseña (opcional)">
                        <button type="submit" name="update">Actualizar</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
    <?php endwhile; ?>
</tbody>

    </table>
        <!-- Footer -->
        <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2024 A Cocinar. Todos los derechos reservados.</p>
        <p>Síguenos en nuestras redes sociales</p>
        <div class="social-icons">
            <img src="..\assets\images\imagenes\Iconos\face.png" alt="Facebook">
            <img src="..\assets\images\imagenes\Iconos\insta.png" alt="Instagram">
            <img src="..\assets\images\imagenes\Iconos\twitter.png" alt="YouTube">
        </div>
    </footer>
</body>
</html>
