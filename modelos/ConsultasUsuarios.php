<?php
require "../config/Conexion.php";

class ConsultasUsuarios {
    public function obtenerUsuarios() {
        $sql = "SELECT id_usuario, nombre_usuario, puntos, cantidad_recetas FROM usuarios";
        return ejecutarConsulta($sql);
    }

    public function insertarUsuario($nombre_usuario, $puntos, $cantidad_recetas) {
        $sql = "INSERT INTO usuarios (nombre_usuario, puntos, cantidad_recetas) 
                VALUES ('$nombre_usuario', '$puntos', '$cantidad_recetas')";
        return ejecutarConsulta($sql);
    }

    public function actualizarUsuario($id_usuario, $nombre_usuario, $puntos, $cantidad_recetas) {
        $sql = "UPDATE usuarios 
                SET nombre_usuario='$nombre_usuario', puntos='$puntos', cantidad_recetas='$cantidad_recetas' 
                WHERE id_usuario=$id_usuario";
        return ejecutarConsulta($sql);
    }

    public function eliminarUsuario($id_usuario) {
        $sql = "DELETE FROM usuarios WHERE id_usuario=$id_usuario";
        return ejecutarConsulta($sql);
    }
}
?>
