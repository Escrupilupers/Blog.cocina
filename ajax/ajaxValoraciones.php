<?php
require_once "../modelos/ConsultasValoraciones.php";

$valoraciones = new ConsultasValoraciones();

$id_valoracion = isset($_POST["id_valoracion"]) ? limpiarCadena($_POST["id_valoracion"]) : "";
$id_receta = isset($_POST["id_receta"]) ? limpiarCadena($_POST["id_receta"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$calificacion = isset($_POST["calificacion"]) ? limpiarCadena($_POST["calificacion"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $valoraciones->obtenerValoraciones();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_valoracion.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_valoracion.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->id_receta,
                "2" => $reg->id_usuario,
                "3" => $reg->calificacion
            ];
        }
        echo json_encode([
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        ]);
        break;

    case 'eliminar':
        $rspta = $valoraciones->eliminarValoracion($id_valoracion);
        echo $rspta ? "Valoración eliminada" : "No se pudo eliminar la valoración";
        break;

    case 'guardaryeditar':
        if (empty($id_valoracion)) {
            $rspta = $valoraciones->insertarValoracion($id_receta, $id_usuario, $calificacion);
            echo $rspta ? "Valoración registrada" : "No se pudo registrar la valoración";
        } else {
            $rspta = $valoraciones->actualizarValoracion($id_valoracion, $id_receta, $id_usuario, $calificacion);
            echo $rspta ? "Valoración actualizada" : "No se pudo actualizar la valoración";
        }
        break;
}
?>
