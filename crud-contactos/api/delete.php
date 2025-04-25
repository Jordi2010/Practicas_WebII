<?php
// Suponiendo que se está recibiendo JSON
header("Content-Type: application/json");

// Verificar el método
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    // Obtener el cuerpo del request
    $input = file_get_contents("php://input");
    $data = json_decode($input);

    if (!isset($data->id)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Se requiere el ID"));
        exit();
    }
    
    try {
        // Asegúrate de tener la conexión $conn definida aquí
        // Por ejemplo: $conn = new PDO(...);

        // Preparar la consulta SQL para eliminar
        $query = "DELETE FROM contactos WHERE id = :id";
        $stmt = $conn->prepare($query);
    
        // Vincular parámetros
        $stmt->bindParam(':id', $data->id);
    
        // Ejecutar consulta
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            http_response_code(200);
            echo json_encode(array(
                "status" => "success",
                "message" => "Contacto eliminado correctamente."
            ));
        } else {
            http_response_code(404);
            echo json_encode(array("status" => "error", "message" => "No se encontró el contacto."));
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error al eliminar"));
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}
?>