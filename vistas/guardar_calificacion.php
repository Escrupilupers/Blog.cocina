<?php
include '../config/Conexion.php';

// Obtener datos enviados
$data = json_decode(file_get_contents("php://input"), true);
$id_receta = intval($data['id_receta']);
$calificacion = intval($data['calificacion']);
$id_usuario = 1; // Cambia esto al ID del usuario autenticado

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
    exit;
}

// Verificar si ya existe una calificación para este usuario y receta
$sql_check = "SELECT id_valoracion FROM valoraciones WHERE id_receta = ? AND id_usuario = ?";
$stmt_check = $conn->prepare($sql_check);

if (!$stmt_check) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación del statement SELECT.', 'error' => $conn->error]);
    exit;
}

$stmt_check->bind_param("ii", $id_receta, $id_usuario);
$stmt_check->execute();
$stmt_check->store_result();

if ($stmt_check->num_rows > 0) {
    // Actualizar la calificación existente
    $sql_update = "UPDATE valoraciones SET calificacion = ? WHERE id_receta = ? AND id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);

    if (!$stmt_update) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación del statement UPDATE.', 'error' => $conn->error]);
        exit;
    }

    $stmt_update->bind_param("iii", $calificacion, $id_receta, $id_usuario);
    $success = $stmt_update->execute();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Calificación actualizada correctamente.' : 'Error al actualizar la calificación.',
        'debug' => $stmt_update->error // Mostrar errores
    ]);

    $stmt_update->close();
} else {
    // Insertar una nueva calificación
    $sql_insert = "INSERT INTO valoraciones (id_receta, id_usuario, calificacion) VALUES (?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);

    if (!$stmt_insert) {
        echo json_encode(['success' => false, 'message' => 'Error en la preparación del statement INSERT.', 'error' => $conn->error]);
        exit;
    }

    $stmt_insert->bind_param("iii", $id_receta, $id_usuario, $calificacion);
    $success = $stmt_insert->execute();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Calificación guardada correctamente.' : 'Error al guardar la calificación.',
        'debug' => $stmt_insert->error // Mostrar errores
    ]);

    $stmt_insert->close();
}

$stmt_check->close();
$conn->close();
?>
