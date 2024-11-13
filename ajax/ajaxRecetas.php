<?php
require_once "../modelos/ConsultasRecetas.php";

$recetas = new ConsultasRecetas();

$id_receta = isset($_POST["id_receta"]) ? limpiarCadena($_POST["id_receta"]) : "";
$titulo = isset($_POST["titulo"]) ? limpiarCadena($_POST["titulo"]) : "";
$calorias = isset($_POST["calorias"]) ? limpiarCadena($_POST["calorias"]) : "";
$tiempo_preparacion = isset($_POST["tiempo_preparacion"]) ? limpiarCadena($_POST["tiempo_preparacion"]) : "";
$categoria = isset($_POST["categoria"]) ? limpiarCadena($_POST["categoria"]) : "";
$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena($_POST["id_usuario"]) : "";
$fecha_modificacion = isset($_POST["fecha_modificacion"]) ? limpiarCadena($_POST["fecha_modificacion"]) : "";

switch ($_GET["op"]) {
    case 'listar':
        $rspta = $recetas->obtenerRecetas();
        $data = [];
        while ($reg = $rspta->fetch_object()) {
            $data[] = [
                "0" => '<button class="btn btn-warning" onclick="mostrar('.$reg->id_receta.')"><i class="fa fa-pencil"></i></button>' .
                       '<button class="btn btn-danger" onclick="eliminar('.$reg->id_receta.')"><i class="fa fa-trash"></i></button>',
                "1" => $reg->titulo,
                "2" => $reg->calorias,
                "3" => $reg->tiempo_preparacion,
                "4" => $reg->categoria,
                "5" => $reg->id_usuario,
                "6" => $reg->fecha_modificacion
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
        $rspta = $recetas->eliminarReceta($id_receta);
        echo $rspta ? "Receta eliminada" : "No se pudo eliminar la receta";
        break;

    case 'guardaryeditar':
        if (empty($id_receta)) {
            $rspta = $recetas->insertarReceta($titulo, $calorias, $tiempo_preparacion, $categoria, $id_usuario, $fecha_modificacion);
            echo $rspta ? "Receta registrada" : "No se pudo registrar la receta";
        } else {
            $rspta = $recetas->actualizarReceta($id_receta, $titulo, $calorias, $tiempo_preparacion, $categoria, $id_usuario, $fecha_modificacion);
            echo $rspta ? "Receta actualizada" : "No se pudo actualizar la receta";
        }
        break;
}
?>
