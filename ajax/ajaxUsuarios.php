<?php
require_once "../modelos/ConsultasUsuarios.php";

$usuarios = new ConsultasUsuarios();

$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$nombre_usuario = isset($_POST["nombre_usuario"]) ? limpiarCadena($_POST["nombre_usuario"]) : "";
$puntos = isset($_POST["puntos"]) ? limpiarCadena($_POST["puntos"]) : "";
$cantidad_recetas = isset($_POST["cantidad_recetas"]) ? limpiarCadena($_POST["cantidad_recetas"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $usuarios->obtenerUsuarios();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_usuario.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_usuario.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->nombre_usuario,
                "2" => $reg->puntos,
                "3" => $reg->cantidad_recetas
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
        $rspta = $usuarios->eliminarUsuario($id_usuario);
        echo $rspta ? "Usuario eliminado" : "No se pudo eliminar el usuario";
        break;

    case 'guardaryeditar':
        if (empty($id_usuario)) {
            $rspta = $usuarios->insertarUsuario($nombre_usuario, $puntos, $cantidad_recetas);
            echo $rspta ? "Usuario registrado" : "No se pudo registrar el usuario";
        } else {
            $rspta = $usuarios->actualizarUsuario($id_usuario, $nombre_usuario, $puntos, $cantidad_recetas);
            echo $rspta ? "Usuario actualizado" : "No se pudo actualizar el usuario";
        }
        break;
}
?>
