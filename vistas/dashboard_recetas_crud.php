<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}

require_once '../config/Conexion.php'; // Asegúrate de que esté correcto.

$id_usuario_session = $_SESSION['id_usuario']; // Obtener el ID del usuario en sesión
$id_rol_session = $_SESSION['id_rol']; // Obtener el rol del usuario en sesión

// CRUD para gestionar recetas y subir imágenes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        if ($id_rol_session == 1 || $id_rol_session == 2) { // Los usuarios también pueden crear recetas
            // Crear receta
            $titulo = $_POST['titulo'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $id_usuario = $_SESSION['id_usuario'];

            // Subir imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = $_FILES['imagen'];
                $nombre_imagen = basename($imagen['name']);
                $tipo_imagen = $imagen['type'];
                $tamanio_imagen = $imagen['size'];

                // Ruta absoluta a la carpeta donde se guardarán las imágenes
                $ruta_imagen = '/blog.cocina/assets/images/imagenes/comida/' . $nombre_imagen;

                // Validar tipo y tamaño de imagen
                $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif'];
                $tamano_maximo = 2 * 1024 * 1024; // 2 MB

                if (in_array($tipo_imagen, $tipos_permitidos) && $tamanio_imagen <= $tamano_maximo) {
                    // Asegúrate de usar la ruta física real del servidor para mover el archivo
                    $ruta_fisica = $_SERVER['DOCUMENT_ROOT'] . $ruta_imagen;

                    if (move_uploaded_file($imagen['tmp_name'], $ruta_fisica)) {
                        // Guardar la ruta relativa en la base de datos
                        $stmt = $conn->prepare("INSERT INTO imagenes (ruta_imagen) VALUES (?)");
                        $stmt->bind_param('s', $ruta_imagen);
                        $stmt->execute();
                        $id_imagen = $conn->insert_id; // Obtener el ID de la imagen recién insertada
                    } else {
                        $error = "Error al mover la imagen al servidor.";
                    }
                } else {
                    $error = "Formato de imagen no permitido o archivo demasiado grande.";
                }
            } else {
                $id_imagen = null; // Si no hay imagen, el ID será null
            }

            // Insertar receta
            if (!isset($error)) {
                $stmt = $conn->prepare("INSERT INTO recetas (titulo, categoria, descripcion, id_usuario, id_imagen) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param('sssis', $titulo, $categoria, $descripcion, $id_usuario, $id_imagen);
                $stmt->execute();
            }
        }
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['id_receta'];

        // Solo se puede eliminar si es administrador o si es la receta del usuario
        $stmt = $conn->prepare("SELECT id_usuario FROM recetas WHERE id_receta = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receta = $result->fetch_assoc();

        if ($id_rol_session == 1 || $receta['id_usuario'] == $id_usuario_session) {
            $stmt = $conn->prepare("DELETE FROM recetas WHERE id_receta = ?");
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
    }

    if (isset($_POST['update'])) {
        $id = $_POST['id_receta'];
        $titulo = $_POST['titulo'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $id_imagen = $_POST['id_imagen']; // Este será el ID de la imagen si la seleccionan

        // Solo se puede actualizar si es administrador o si es la receta del usuario
        $stmt = $conn->prepare("SELECT id_usuario FROM recetas WHERE id_receta = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $receta = $result->fetch_assoc();

        if ($id_rol_session == 1 || $receta['id_usuario'] == $id_usuario_session) {
            $stmt = $conn->prepare("UPDATE recetas SET titulo = ?, categoria = ?, descripcion = ?, id_imagen = ? WHERE id_receta = ?");
            $stmt->bind_param('sssii', $titulo, $categoria, $descripcion, $id_imagen, $id);
            $stmt->execute();
        }
    }
}

// Obtener todas las recetas
if ($id_rol_session == 1) {
    $result = $conn->query("SELECT * FROM recetas");
} else {
    // Los usuarios solo ven sus propias recetas
    $stmt = $conn->prepare("SELECT * FROM recetas WHERE id_usuario = ?");
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
    <title>Gestión de Recetas</title>
    <link rel="stylesheet" href="../assets/librerias/estilos_crud.css">
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></h2>
    <a href="logout.php">Cerrar Sesión</a>
    
    <!-- Menú de navegación -->
    <nav>
        <ul>
            <li><a href="dashboard_login_crud.php">Usuarios</a></li>
            <li><a href="dashboard_recetas_crud.php">Recetas</a></li>
        </ul>
    </nav>

    <h3>Gestión de Recetas</h3>
    <?php if ($id_rol_session == 1 || $id_rol_session == 2): ?>
        <form method="POST" enctype="multipart/form-data">
            <label>Título:</label>
            <input type="text" name="titulo" required>

            <label>Categoría:</label>
            <select name="categoria" required>
                <option value="Almuerzo">Almuerzo</option>
                <option value="Cena">Cena</option>
                <option value="Postre">Postre</option>
                <option value="Antojo">Antojo</option>
            </select>

            <label>Descripción:</label>
            <textarea name="descripcion" required></textarea>
            
            <!-- Campo para subir imagen -->
            <label>Imagen:</label>
            <input type="file" name="imagen" accept="image/*" required>

            <button type="submit" name="create">Crear Receta</button>
        </form>
    <?php endif; ?>

    <h3>Recetas Existentes</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id_receta']; ?></td>
                    <td><?php echo $row['titulo']; ?></td>
                    <td><?php echo $row['categoria']; ?></td>
                    <td><?php echo $row['descripcion']; ?></td>
                    <td>
                        <?php
                        if ($row['id_imagen']) {
                            $stmt = $conn->prepare("SELECT ruta_imagen FROM imagenes WHERE id_imagen = ?");
                            $stmt->bind_param('i', $row['id_imagen']);
                            $stmt->execute();
                            $imagen_result = $stmt->get_result();
                            $imagen = $imagen_result->fetch_assoc();
                            echo "<img src='../" . $imagen['ruta_imagen'] . "' width='100' alt='Imagen de receta'>";
                        } else {
                            echo "Sin imagen";
                        }
                        ?>
                    </td>
                    <td>
                        <?php if ($id_rol_session == 1 || $row['id_usuario'] == $id_usuario_session): ?>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id_receta" value="<?php echo $row['id_receta']; ?>">
                                <button type="submit" name="delete">Eliminar</button>
                            </form>
                            <form method="POST" style="display:inline-block;">
                                <input type="hidden" name="id_receta" value="<?php echo $row['id_receta']; ?>">
                                <input type="text" name="titulo" value="<?php echo $row['titulo']; ?>" required>
                                <select name="categoria" required>
                                    <option value="Almuerzo" <?php if ($row['categoria'] == 'Almuerzo') echo 'selected'; ?>>Almuerzo</option>
                                    <option value="Cena" <?php if ($row['categoria'] == 'Cena') echo 'selected'; ?>>Cena</option>
                                    <option value="Postre" <?php if ($row['categoria'] == 'Postre') echo 'selected'; ?>>Postre</option>
                                    <option value="Antojo" <?php if ($row['categoria'] == 'Antojo') echo 'selected'; ?>>Antojo</option>
                                </select>
                                <textarea name="descripcion" required><?php echo $row['descripcion']; ?></textarea>
                                <label>Imagen ID (opcional):</label>
                                <input type="text" name="id_imagen" value="<?php echo $row['id_imagen']; ?>" placeholder="ID de imagen">
                                <button type="submit" name="update">Actualizar</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    
</body>
</html>