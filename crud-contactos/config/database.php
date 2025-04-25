<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=crud_contactos', 'root', "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(array("status" => "error", "message" => "Error de conexión: ".$e->getMessage()));
    die();
}
?>