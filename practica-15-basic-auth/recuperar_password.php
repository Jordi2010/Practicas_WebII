<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];

    // Verificar si el usuario existe
    $stmt = $conexion->prepare("SELECT email FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $email = $fila["email"];

        // Generar token único
        $token = bin2hex(random_bytes(32));

        // Guardar token en la base de datos
        $stmt = $conexion->prepare("INSERT INTO recuperaciones (usuario, token) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $token);
        $stmt->execute();

        // Enlace de recuperación (en la práctica real se enviaría por correo)
        echo "Se ha enviado un enlace de recuperación a: " . htmlspecialchars($email) . "<br>";
        echo "<a href='reset_password.php?token=$token'>Recuperar contraseña</a>";
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
}
?>

<h2>Recuperar contraseña</h2>
<form method="post">
    <label>Usuario:</label>
    <input type="text" name="usuario" required>
    <button type="submit">Recuperar</button>
</form>