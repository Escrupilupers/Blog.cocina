<?php
require "../config/Conexion.php";

class ConsultasMensajes {
    public function obtenerMensajes() {
        $sql = "SELECT id_mensaje, id_usuario, contenido, fecha FROM mensajes";
        return ejecutarConsulta($sql);
    }

    public function insertarMensaje($id_usuario, $contenido, $fecha) {
        $sql = "INSERT INTO mensajes (id_usuario, contenido, fecha) 
                VALUES ('$id_usuario', '$contenido', '$fecha')";
        return ejecutarConsulta($sql);
    }

    public function actualizarMensaje($id_mensaje, $id_usuario, $contenido, $fecha) {
        $sql = "UPDATE mensajes 
                SET id_usuario='$id_usuario', contenido='$contenido', fecha='$fecha' 
                WHERE id_mensaje=$id_mensaje";
        return ejecutarConsulta($sql);
    }

    public function eliminarMensaje($id_mensaje) {
        $sql = "DELETE FROM mensajes WHERE id_mensaje=$id_mensaje";
        return ejecutarConsulta($sql);
    }
}
?>
