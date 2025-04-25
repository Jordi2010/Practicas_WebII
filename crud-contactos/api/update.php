<?php
// Suponiendo que ya está la conexión en $conn y se ha recibido el JSON con file_get_contents
$conn = new PDO("mysql:host=localhost;dbname=crud_contactos", "root", "");
$data = json_decode(file_get_contents("php://input"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($data->id) || empty($data->nombre) || empty($data->email)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Se requiere ID, nombre y email."));
        exit();
    }
    
    try {
        // Preparar la consulta SQL para actualizar
        $query = "UPDATE contactos SET nombre = :nombre, email = :email, telefono = :telefono WHERE id = :id";
        $stmt = $conn->prepare($query);
    
        // Vincular parámetros
        $stmt->bindParam(':id', $data->id);
        $stmt->bindParam(':nombre', $data->nombre);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':telefono', $data->telefono);
    
        // Ejecutar consulta
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "message" => "Contacto actualizado correctamente."
            ));
        } else {
            http_response_code(404);
            echo json_encode(array("status" => "error", "message" => "No se encontró el contacto."));
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error al actualizar el contacto: ".$e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}
?>