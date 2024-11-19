<?php
require_once "global.php";  // Asegúrate de que global.php contenga las configuraciones de tu base de datos
$conexion = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Establecer el conjunto de caracteres a UTF-8
mysqli_query($conexion, 'SET NAMES "'.DB_ENCODE.'"');

// Verificar si hay algún error en la conexión
if (mysqli_connect_errno()) {
    printf("Falló la conexión a la base de datos: %s\n", mysqli_connect_error());
    exit();
}

// Compatibilidad con `$conn`
$conn = $conexion;

if (!function_exists('ejecutarConsulta')) {
    /**
     * Ejecutar una consulta SQL general
     */
    function ejecutarConsulta($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        return $query;
    }

    /**
     * Ejecutar una consulta SQL y obtener una fila de resultados
     */
    function ejecutarConsultaSimpleFila($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        $row = $query->fetch_assoc();
        return $row;
    }

    /**
     * Ejecutar una consulta y retornar el ID del último registro insertado
     */
    function ejecutarConsulta_retornarID($sql) {
        global $conexion;
        $query = $conexion->query($sql);
        return $conexion->insert_id;
    }

    /**
     * Limpiar una cadena de caracteres (para evitar inyecciones SQL y XSS)
     */
    function limpiarCadena($str) {
        global $conexion;
        $str = mysqli_real_escape_string($conexion, trim($str));
        return htmlspecialchars($str);
    }

    /**
     * Obtener una lista de todas las categorías de recetas (ejemplo de uso en el blog de cocina)
     */
    function obtenerCategorias() {
        $sql = "SELECT * FROM categorias ORDER BY nombre_categoria ASC";  // Asegúrate de que 'categorias' exista en tu base de datos
        return ejecutarConsulta($sql);
    }

    /**
     * Obtener una receta por su ID
     */
    function obtenerRecetaPorID($id) {
        $id = limpiarCadena($id);
        $sql = "SELECT * FROM recetas WHERE id_receta = '$id'";  // Asegúrate de que 'recetas' tenga los campos necesarios
        return ejecutarConsultaSimpleFila($sql);
    }

    /**
     * Insertar una nueva receta (ejemplo básico)
     */
    function insertarReceta($titulo, $descripcion, $categoria_id, $ingredientes, $instrucciones, $imagen_url) {
        $titulo = limpiarCadena($titulo);
        $descripcion = limpiarCadena($descripcion);
        $categoria_id = limpiarCadena($categoria_id);
        $ingredientes = limpiarCadena($ingredientes);
        $instrucciones = limpiarCadena($instrucciones);

        $sql = "INSERT INTO recetas (titulo, descripcion, categoria_id, ingredientes, instrucciones, imagen_url) 
                VALUES ('$titulo', '$descripcion', '$categoria_id', '$ingredientes', '$instrucciones')";
        return ejecutarConsulta_retornarID($sql);
    }

    /**
     * Obtener los comentarios de una receta
     */
    function obtenerComentariosReceta($id_receta) {
        $id_receta = limpiarCadena($id_receta);
        $sql = "SELECT * FROM comentarios WHERE receta_id = '$id_receta' ORDER BY fecha_comentario DESC";
        return ejecutarConsulta($sql);
    }

    /**
     * Insertar un comentario en una receta
     */
    function insertarComentario($receta_id, $nombre_usuario, $comentario) {
        $receta_id = limpiarCadena($receta_id);
        $nombre_usuario = limpiarCadena($nombre_usuario);
        $comentario = limpiarCadena($comentario);

        $sql = "INSERT INTO comentarios (receta_id, nombre_usuario, comentario, fecha_comentario) 
                VALUES ('$receta_id', '$nombre_usuario', '$comentario', NOW())";
        return ejecutarConsulta_retornarID($sql);
    }
}
?>