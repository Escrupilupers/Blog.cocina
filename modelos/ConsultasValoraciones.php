<?php
require "../config/Conexion.php";

class ConsultasValoraciones {
    public function obtenerValoraciones() {
        $sql = "SELECT id_valoracion, id_receta, id_usuario, calificacion FROM valoraciones";
        return ejecutarConsulta($sql);
    }

    public function insertarValoracion($id_receta, $id_usuario, $calificacion) {
        $sql = "INSERT INTO valoraciones (id_receta, id_usuario, calificacion) 
                VALUES ('$id_receta', '$id_usuario', '$calificacion')";
        return ejecutarConsulta($sql);
    }

    public function actualizarValoracion($id_valoracion, $id_receta, $id_usuario, $calificacion) {
        $sql = "UPDATE valoraciones 
                SET id_receta='$id_receta', id_usuario='$id_usuario', calificacion='$calificacion' 
                WHERE id_valoracion=$id_valoracion";
        return ejecutarConsulta($sql);
    }

    public function eliminarValoracion($id_valoracion) {
        $sql = "DELETE FROM valoraciones WHERE id_valoracion=$id_valoracion";
        return ejecutarConsulta($sql);
    }
}
?>
