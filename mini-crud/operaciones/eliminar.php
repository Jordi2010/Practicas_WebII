<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Operación eliminar -->

<?php
require_once '../conexion/db.php';

// Verificar si se recibió un ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar consulta SQL
    $sql = "DELETE FROM productos WHERE id = $id";

    // Ejecutar consulta
    if (mysqli_query($conexion, $sql)) {
        header("Location: ../index.php?mensaje=Producto eliminado correctamente");
    } else {
        echo "Error al eliminar: ".mysqli_error($conexion);
    }
} else {
    header("Location: ../index.php");
}

mysqli_close($conexion);
?>