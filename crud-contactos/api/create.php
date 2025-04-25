<?php
header("Content-Type: application/json");

// Verificando si es método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del body
    $data = json_decode(file_get_contents("php://input"));

    // Validar campos obligatorios
    if (empty($data->nombre) || empty($data->email)) {
        http_response_code(400);
        echo json_encode(array("status" => "error", "message" => "Los campos 'nombre' y 'email' son obligatorios."));
        exit();
    }
    
    try {
        // Conexión a la base de datos

        // Preparar la consulta SQL para insertar
        $query = "INSERT INTO contactos (nombre, email, telefono) VALUES (:nombre, :email, :telefono)";
        $stmt = $conn->prepare($query);
    
        // Vincular parámetros
        $stmt->bindParam(':nombre', $data->nombre);
        $stmt->bindParam(':email', $data->email);
        $stmt->bindParam(':telefono', $data->telefono);
    
        // Ejecutar consulta
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(array(
                "status" => "success",
                "message" => "Contacto creado correctamente.",
                "id" => $conn->lastInsertId()
            ));
        } else {
            http_response_code(500);
            echo json_encode(array("status" => "error", "message" => "No se pudo crear el contacto."));
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(array("status" => "error", "message" => "Error al crear contacto: ".$e->getMessage()));
    }
} else {
    http_response_code(405);
    echo json_encode(array("status" => "error", "message" => "Método no permitido."));
}
?>