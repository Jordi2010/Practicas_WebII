<?php
// Parámetros de conexión
$servidor = "localhost";
$usuario = "root";
$password = "";
$basedatos = "biblioteca";

// Crear conexión con manejo de errores
try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$basedatos;charset=utf8", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: ".$e->getMessage());
}
?>