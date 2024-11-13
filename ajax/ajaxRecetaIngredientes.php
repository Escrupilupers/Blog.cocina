<?php
require_once "../modelos/ConsultasRecetaIngredientes.php";

$recetaIngredientes = new ConsultasRecetaIngredientes();

$id_receta = isset($_POST["id_receta"]) ? limpiarCadena($_POST["id_receta"]) : "";
$id_ingrediente = isset($_POST["id_ingrediente"]) ? limpiarCadena($_POST["id_ingrediente"]) : "";
$cantidad = isset($_POST["cantidad"]) ? limpiarCadena($_POST["cantidad"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $recetaIngredientes->obtenerRecetaIngredientes();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_receta.', '.$reg->id_ingrediente.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_receta.', '.$reg->id_ingrediente.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->id_receta,
                "2" => $reg->id_ingrediente,
                "3" => $reg->cantidad
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
        $rspta = $recetaIngredientes->eliminarRecetaIngrediente($id_receta, $id_ingrediente);
        echo $rspta ? "Ingrediente de la receta eliminado" : "No se pudo eliminar el ingrediente de la receta";
        break;

    case 'guardaryeditar':
        if (empty($id_receta) || empty($id_ingrediente)) {
            $rspta = $recetaIngredientes->insertarRecetaIngrediente($id_receta, $id_ingrediente, $cantidad);
            echo $rspta ? "Ingrediente registrado en la receta" : "No se pudo registrar el ingrediente en la receta";
        } else {
            $rspta = $recetaIngredientes->actualizarRecetaIngrediente($id_receta, $id_ingrediente, $cantidad);
            echo $rspta ? "Ingrediente actualizado en la receta" : "No se pudo actualizar el ingrediente de la receta";
        }
        break;
}
?>
