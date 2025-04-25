<?php
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Conexión a la base de datos
        $pdo = new PDO("mysql:host=localhost;dbname=crud_contactos","root","");

        // Suponiendo que esta es la consulta
        $query = "SELECT * FROM contactos";

        $stmt = $pdo->prepare($query);
        $stmt->execute();

        // Verificar si existen contactos
        if ($stmt->rowCount() > 0) {
            $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "data" => $contactos
            ));
        } else {
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "data" => [],
                "message" => "No se encontraron contactos."
            ));
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array(
            "status" => "error",
            "message" => "Error al obtener: ".$e->getMessage()
        ));
    }
} else {
    http_response_code(405);
    echo json_encode(array(
        "status" => "error",
        "message" => "Método no permitido."
    ));
}
?>