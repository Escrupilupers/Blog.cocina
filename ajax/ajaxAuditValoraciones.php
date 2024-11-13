<?php
require_once "../modelos/ConsultasAuditValoraciones.php";

$auditValoraciones = new ConsultasAuditValoraciones();

$id_valoracion = isset($_POST["id_valoracion"]) ? limpiarCadena($_POST["id_valoracion"]) : "";
$calificacion_anterior = isset($_POST["calificacion_anterior"]) ? limpiarCadena($_POST["calificacion_anterior"]) : "";
$calificacion_nueva = isset($_POST["calificacion_nueva"]) ? limpiarCadena($_POST["calificacion_nueva"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $auditValoraciones->obtenerAuditValoraciones();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_valoracion.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_valoracion.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->calificacion_anterior,
                "2" => $reg->calificacion_nueva,
                "3" => $reg->fecha
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
        $rspta = $auditValoraciones->eliminarAuditValoracion($id_valoracion);
        echo $rspta ? "Valoración auditada eliminada" : "No se pudo eliminar la valoración auditada";
        break;

    case 'guardaryeditar':
        if (empty($id_valoracion)) {
            $rspta = $auditValoraciones->insertarAuditValoracion($calificacion_anterior, $calificacion_nueva, $fecha);
            echo $rspta ? "Valoración auditada registrada" : "No se pudo registrar la valoración auditada";
        } else {
            $rspta = $auditValoraciones->actualizarAuditValoracion($id_valoracion, $calificacion_anterior, $calificacion_nueva, $fecha);
            echo $rspta ? "Valoración auditada actualizada" : "No se pudo actualizar la valoración auditada";
        }
        break;
}
?>
