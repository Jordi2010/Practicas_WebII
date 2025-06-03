<?php
require 'conexion.php';

if (isset($_GET["token"])) {
    $token = $_GET["token"];

    // Validar token válido y no usado, dentro de 1 hora
    $stmt = $conexion->prepare("SELECT usuario FROM recuperaciones WHERE token = ? AND usado = 0 AND creado_en >= NOW() - INTERVAL 1 HOUR");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $fila = $resultado->fetch_assoc();
        $usuario = $fila["usuario"];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $nueva_password = password_hash($_POST["nueva_password"], PASSWORD_DEFAULT);

            // Actualizar contraseña del usuario
            $stmt = $conexion->prepare("UPDATE usuarios SET password = ? WHERE usuario = ?");
            $stmt->bind_param("ss", $nueva_password, $usuario);
            $stmt->execute();

            // Marcar token como usado
            $stmt = $conexion->prepare("UPDATE recuperaciones SET usado = 1 WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            echo "Contraseña actualizada correctamente. <a href='index.php'>Iniciar sesión</a>";
            exit;
        }

        ?>
        <h2>Establecer nueva contraseña</h2>
        <form method="post">
            <label>Nueva contraseña:</label>
            <input type="password" name="nueva_password" required>
            <button type="submit">Actualizar contraseña</button>
        </form>
        <?php
    } else {
        echo "Token inválido o expirado.";
    }

    $stmt->close();
} else {
    echo "Token no proporcionado.";
}
?>