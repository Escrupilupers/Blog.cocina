<?php
include '../config/Conexion.php';

if (isset($_POST['query'])) {
    $query = $_POST['query'];
    $output = '';

    // Realizar la consulta con LIKE para autocompletar
    $sql = "SELECT titulo FROM recetas WHERE titulo LIKE '%$query%' LIMIT 5";
    $result = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $output .= '<p>' . $row['titulo'] . '</p>';
        }
    } else {
        $output .= '<p>No se encontraron resultados</p>';
    }
    echo $output;
}
?>
