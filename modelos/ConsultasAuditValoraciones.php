<?php
require "../config/Conexion.php";

class ConsultasAuditValoraciones {
    public function obtenerAuditValoraciones() {
        $sql = "SELECT id_valoracion, calificacion_anterior, calificacion_nueva, fecha FROM audit_valoraciones";
        return ejecutarConsulta($sql);
    }

    public function insertarAuditValoracion($calificacion_anterior, $calificacion_nueva, $fecha) {
        $sql = "INSERT INTO audit_valoraciones (calificacion_anterior, calificacion_nueva, fecha) 
                VALUES ('$calificacion_anterior', '$calificacion_nueva', '$fecha')";
        return ejecutarConsulta($sql);
    }

    public function actualizarAuditValoracion($id_valoracion, $calificacion_anterior, $calificacion_nueva, $fecha) {
        $sql = "UPDATE audit_valoraciones 
                SET calificacion_anterior='$calificacion_anterior', calificacion_nueva='$calificacion_nueva', fecha='$fecha' 
                WHERE id_valoracion=$id_valoracion";
        return ejecutarConsulta($sql);
    }

    public function eliminarAuditValoracion($id_valoracion) {
        $sql = "DELETE FROM audit_valoraciones WHERE id_valoracion=$id_valoracion";
        return ejecutarConsulta($sql);
    }
}
?>
