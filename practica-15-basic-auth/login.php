<?php
require 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $stmt = $conexion->prepare("SELECT password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila["password"])) {
            $usuario_valido = true;
            $_SESSION["usuario"] = $usuario;
            session_regenerate_id(); // Seguridad contra secuestro de sesión
            header("Location: bienvenida.php");
            exit;
        } else {
            $usuario_valido = false;
            echo "Contraseña incorrecta.";
        }
    } else {
        $usuario_valido = false;
        echo "Usuario no encontrado.";
    }

    // Guardar intento de login
    $stmt_log = $conexion->prepare("INSERT INTO historial_logins (usuario, exito) VALUES (?, ?)");
    $exito = $usuario_valido ? 1 : 0;
    $stmt_log->bind_param("si", $usuario, $exito);
    $stmt_log->execute();
    $stmt_log->close();

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Sistema Seguro</title>
</head>
<body>
    <a href="index.php" class="nav-home">← Inicio</a>
    
    <div class="login-container">
        <div class="login-header">
            <h1>🔐 Iniciar Sesión</h1>
            <p>Accede a tu cuenta de forma segura</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <form method="post">
            <label>Usuario:</label>
            <input type="text" name="usuario" required><br>
            <label>Contraseña:</label>
            <input type="password" name="password" required><br>
            <button type="submit">Ingresar</button>
        </form>
        
        <div class="links">
            <p><a href="recuperar_password.php">¿Olvidaste tu contraseña?</a></p>
            <a href="crear_usuario.php">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</body>
</html>