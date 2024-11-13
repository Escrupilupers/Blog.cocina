<?php
require "../config/Conexion.php";

class ConsultasIngredientes {
    public function obtenerIngredientes() {
        $sql = "SELECT id_ingrediente, nombre_ingrediente FROM ingredientes";
        return ejecutarConsulta($sql);
    }

    public function insertarIngrediente($nombre_ingrediente) {
        $sql = "INSERT INTO ingredientes (nombre_ingrediente) 
                VALUES ('$nombre_ingrediente')";
        return ejecutarConsulta($sql);
    }

    public function actualizarIngrediente($id_ingrediente, $nombre_ingrediente) {
        $sql = "UPDATE ingredientes SET nombre_ingrediente='$nombre_ingrediente' WHERE id_ingrediente=$id_ingrediente";
        return ejecutarConsulta($sql);
    }

    public function eliminarIngrediente($id_ingrediente) {
        $sql = "DELETE FROM ingredientes WHERE id_ingrediente=$id_ingrediente";
        return ejecutarConsulta($sql);
    }
}
?>
