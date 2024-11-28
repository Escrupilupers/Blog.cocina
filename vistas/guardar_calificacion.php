<?php
include '../config/Conexion.php';

// Verificar que se recibieron los datos correctamente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validar datos
    if (!isset($data['id_receta'], $data['calificacion']) || !is_numeric($data['id_receta']) || !is_numeric($data['calificacion'])) {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos o incompletos.']);
        exit();
    }

    $id_receta = intval($data['id_receta']);
    $calificacion = intval($data['calificacion']);
    $id_usuario = 1; // Reemplazar con el ID del usuario autenticado

    // Validar rangos de valores
    if ($calificacion < 1 || $calificacion > 5) {
        echo json_encode(['success' => false, 'message' => 'La calificación debe estar entre 1 y 5.']);
        exit();
    }

    try {
        // Comprobar si ya existe una valoración para este usuario y receta
        $sql_check = "
            SELECT id_valoracion 
            FROM valoraciones 
            WHERE id_receta = ? AND id_usuario = ?
        ";
        $stmt = $conn->prepare($sql_check);
        $stmt->bind_param('ii', $id_receta, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Actualizar calificación existente
            $sql_update = "
                UPDATE valoraciones 
                SET calificacion = ? 
                WHERE id_receta = ? AND id_usuario = ?
            ";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('iii', $calificacion, $id_receta, $id_usuario);

            if (!$stmt_update->execute()) {
                throw new Exception('Error al actualizar la calificación.');
            }

            $message = 'Calificación actualizada correctamente.';
        } else {
            // Insertar nueva calificación
            $sql_insert = "
                INSERT INTO valoraciones (id_receta, id_usuario, calificacion) 
                VALUES (?, ?, ?)
            ";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param('iii', $id_receta, $id_usuario, $calificacion);

            if (!$stmt_insert->execute()) {
                throw new Exception('Error al guardar la calificación.');
            }

            $message = 'Calificación registrada correctamente.';
        }

        echo json_encode(['success' => true, 'message' => $message]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>
