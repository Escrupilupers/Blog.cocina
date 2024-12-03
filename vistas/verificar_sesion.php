<?php
session_start();
header('Content-Type: application/json');

// Comprobar si el usuario ha iniciado sesión
if (isset($_SESSION['id_usuario'])) {
    echo json_encode(['autenticado' => true, 'id_usuario' => $_SESSION['id_usuario']]);
} else {
    echo json_encode(['autenticado' => false]);
}
?>