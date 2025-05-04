<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Conexión a la base de datos -->

<?php
// Parámetros de conexión
$servidor = "localhost";
$usuario = "root";
$password = "";
$basedatos = "mini_crud";

// Crear conexión
$conexion = mysqli_connect($servidor, $usuario, $password, $basedatos);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: ".mysqli_connect_error());
}

// Establecer codificación de caracteres
mysqli_set_charset($conexion, "utf8");
?>