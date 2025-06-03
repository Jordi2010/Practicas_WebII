<?php
// conexion.php
$host = 'localhost';
$db   = 'seguridad';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$opciones = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, $opciones);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
