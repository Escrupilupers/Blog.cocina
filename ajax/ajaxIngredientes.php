<?php
require_once "../modelos/ConsultasIngredientes.php";

$ingredientes = new ConsultasIngredientes();

$id_ingrediente = isset($_POST["id_ingrediente"]) ? limpiarCadena($_POST["id_ingrediente"]) : "";
$nombre_ingrediente = isset($_POST["nombre_ingrediente"]) ? limpiarCadena($_POST["nombre_ingrediente"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $ingredientes->obtenerIngredientes();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_ingrediente.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_ingrediente.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->nombre_ingrediente
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
        $rspta = $ingredientes->eliminarIngrediente($id_ingrediente);
        echo $rspta ? "Ingrediente eliminado" : "No se pudo eliminar el ingrediente";
        break;

    case 'guardaryeditar':
        if (empty($id_ingrediente)) {
            $rspta = $ingredientes->insertarIngrediente($nombre_ingrediente);
            echo $rspta ? "Ingrediente registrado" : "No se pudo registrar el ingrediente";
        } else {
            $rspta = $ingredientes->actualizarIngrediente($id_ingrediente, $nombre_ingrediente);
            echo $rspta ? "Ingrediente actualizado" : "No se pudo actualizar el ingrediente";
        }
        break;
}
?>
