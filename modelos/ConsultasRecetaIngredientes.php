<?php
require "../config/Conexion.php";

class ConsultasRecetaIngredientes {
    public function obtenerRecetaIngredientes() {
        $sql = "SELECT id_receta, id_ingrediente, cantidad FROM receta_ingredientes";
        return ejecutarConsulta($sql);
    }

    public function insertarRecetaIngrediente($id_receta, $id_ingrediente, $cantidad) {
        $sql = "INSERT INTO receta_ingredientes (id_receta, id_ingrediente, cantidad) 
                VALUES ('$id_receta', '$id_ingrediente', '$cantidad')";
        return ejecutarConsulta($sql);
    }

    public function actualizarRecetaIngrediente($id_receta, $id_ingrediente, $cantidad) {
        $sql = "UPDATE receta_ingredientes 
                SET cantidad='$cantidad' 
                WHERE id_receta='$id_receta' AND id_ingrediente='$id_ingrediente'";
        return ejecutarConsulta($sql);
    }

    public function eliminarRecetaIngrediente($id_receta, $id_ingrediente) {
        $sql = "DELETE FROM receta_ingredientes WHERE id_receta='$id_receta' AND id_ingrediente='$id_ingrediente'";
        return ejecutarConsulta($sql);
    }
}
?>
