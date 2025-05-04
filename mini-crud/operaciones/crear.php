<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Operación crear -->

<?php
require_once '../conexion/db.php';

// Verificar si se recibieron datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $categoria_id = $_POST['categoria_id'];

    // Preparar consulta SQL
    $sql = "INSERT INTO productos (nombre, precio, stock, categoria_id)
    VALUES ($nombre, $precio, $stock, $categoria_id)";

    // Ejecutar consulta
    if (mysqli_query($conexion, $sql)) {
        // Redirigir al listado con mensaje de éxito
        header("Location: ../index.php?mensaje=Producto creado con éxito");
    } else {
        echo "Error al crear el producto: ".mysqli_error($conexion);
    }
} else {
    // Si no es una solicitud POST, redirigir
    header("Location: ../index.php");
}

mysqli_close($conexion);
?>