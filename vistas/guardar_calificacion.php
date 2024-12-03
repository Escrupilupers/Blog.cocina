<?php
session_start();
include '../config/Conexion.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['id_usuario'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Debes iniciar sesión para calificar.',
        'debug' => 'No hay sesión activa'
    ]);
    exit;
}

// Obtener datos enviados
$data = json_decode(file_get_contents("php://input"), true);
$id_receta = intval($data['id_receta']);
$calificacion = intval($data['calificacion']);
$id_usuario = $_SESSION['id_usuario']; // ID del usuario autenticado desde la sesión

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
    $stmt_insert->close();
}

$stmt_check->close();

// Calcular el nuevo promedio
$sql_promedio = "SELECT AVG(calificacion) AS promedio_calificacion FROM valoraciones WHERE id_receta = ?";
$stmt_promedio = $conn->prepare($sql_promedio);

if (!$stmt_promedio) {
    echo json_encode(['success' => false, 'message' => 'Error al calcular el promedio.', 'error' => $conn->error]);
    exit;
}

$stmt_promedio->bind_param("i", $id_receta);
$stmt_promedio->execute();
$result_promedio = $stmt_promedio->get_result();

if ($result_promedio && $row = $result_promedio->fetch_assoc()) {
    $promedio_calificacion = round($row['promedio_calificacion']);
    echo json_encode([
        'success' => true,
        'message' => $success ? 'Calificación guardada correctamente.' : 'Error al guardar la calificación.',
        'promedio_calificacion' => $promedio_calificacion
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al calcular el promedio.']);
}

$stmt_promedio->close();
$conn->close();
?>