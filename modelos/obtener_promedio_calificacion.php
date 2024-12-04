<?php
include '../config/Conexion.php';

if (isset($_GET['id_receta'])) {
    $id_receta = intval($_GET['id_receta']);
    $sql = "
        SELECT AVG(calificacion) AS promedio_calificacion
        FROM valoraciones 
        WHERE id_receta = $id_receta
    ";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode(['promedio_calificacion' => round($row['promedio_calificacion'])]);
    } else {
        echo json_encode(['promedio_calificacion' => 0]);
    }
} else {
    echo json_encode(['promedio_calificacion' => 0]);
}
?>
