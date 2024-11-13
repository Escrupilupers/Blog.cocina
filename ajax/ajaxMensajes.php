<?php
require_once "../modelos/ConsultasMensajes.php";

$mensajes = new ConsultasMensajes();

$id_mensaje = isset($_POST["id_mensaje"]) ? limpiarCadena($_POST["id_mensaje"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$contenido = isset($_POST["contenido"]) ? limpiarCadena($_POST["contenido"]) : "";
$fecha = isset($_POST["fecha"]) ? limpiarCadena($_POST["fecha"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $mensajes->obtenerMensajes();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_mensaje.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_mensaje.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->id_usuario,
                "2" => $reg->contenido,
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
        $rspta = $mensajes->eliminarMensaje($id_mensaje);
        echo $rspta ? "Mensaje eliminado" : "No se pudo eliminar el mensaje";
        break;

    case 'guardaryeditar':
        if (empty($id_mensaje)) {
            $rspta = $mensajes->insertarMensaje($id_usuario, $contenido, $fecha);
            echo $rspta ? "Mensaje registrado" : "No se pudo registrar el mensaje";
        } else {
            $rspta = $mensajes->actualizarMensaje($id_mensaje, $id_usuario, $contenido, $fecha);
            echo $rspta ? "Mensaje actualizado" : "No se pudo actualizar el mensaje";
        }
        break;
}
?>
