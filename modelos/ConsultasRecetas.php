<?php
require "../config/Conexion.php";

class ConsultasRecetas {
    public function obtenerRecetas() {
        $sql = "SELECT id_receta, titulo, calorias, tiempo_preparacion, categoria, id_usuario, fecha_modificacion FROM recetas";
        return ejecutarConsulta($sql);
    }

    public function insertarReceta($titulo, $calorias, $tiempo_preparacion, $categoria, $id_usuario, $fecha_modificacion) {
        $sql = "INSERT INTO recetas (titulo, calorias, tiempo_preparacion, categoria, id_usuario, fecha_modificacion) 
                VALUES ('$titulo', '$calorias', '$tiempo_preparacion', '$categoria', '$id_usuario', '$fecha_modificacion')";
        return ejecutarConsulta($sql);
    }

    public function actualizarReceta($id_receta, $titulo, $calorias, $tiempo_preparacion, $categoria, $id_usuario, $fecha_modificacion) {
        $sql = "UPDATE recetas 
                SET titulo='$titulo', calorias='$calorias', tiempo_preparacion='$tiempo_preparacion', categoria='$categoria', 
                id_usuario='$id_usuario', fecha_modificacion='$fecha_modificacion' 
                WHERE id_receta=$id_receta";
        return ejecutarConsulta($sql);
    }

    public function eliminarReceta($id_receta) {
        $sql = "DELETE FROM recetas WHERE id_receta=$id_receta";
        return ejecutarConsulta($sql);
    }
}
?>
