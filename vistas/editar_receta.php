<?php include 'C:\xampp\htdocs\blog.cocina\ajax\php del html\conexion.php'; ?>

<?php
session_start();
$usuario_id = $_SESSION['usuario_id']; // Asegúrate de tener este valor al iniciar sesión

$sql = "SELECT * FROM recetas WHERE usuario_id = $usuario_id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo "<form method='POST' action='actualizar_receta.php'>";
    echo "<input type='hidden' name='receta_id' value='" . $row['id'] . "'>";
    echo "<label>Nombre de la receta:</label>";
    echo "<input type='text' name='nombre' value='" . $row['nombre'] . "' required><br>";

    $sql_ingredientes = "SELECT i.id, i.nombre FROM receta_ingredientes ri JOIN ingredientes i ON ri.ingrediente_id = i.id WHERE ri.receta_id = " . $row['id'];
    $result_ingredientes = $conn->query($sql_ingredientes);

    echo "<label>Ingredientes:</label><ul>";
    while ($ingrediente = $result_ingredientes->fetch_assoc()) {
        echo "<li><input type='text' name='ingredientes[]' value='" . $ingrediente['nombre'] . "'></li>";
    }
    echo "</ul>";

    echo "<label>Pasos:</label>";
    echo "<textarea name='pasos' required>" . $row['pasos'] . "</textarea><br>";

    echo "<input type='submit' value='Actualizar'>";
    echo "</form><hr>";
}
?>