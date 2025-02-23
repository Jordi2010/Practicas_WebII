<!-- Práctica 2 (ejercicio 2)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 2. Sistema de autenticación.
Crea un sistema de login que verifique:
- Si el usuario está bloqueado -> "Cuenta bloqueada".
- Si el usuario existe y la contraseña coincide -> "Acceso permitido".
- Si el usuario existe, pero la contraseña no coincide:
    * Si los intentos son menores a 3 -> "Contraseña incorrecta, intentos restantes: X".
    * Si los intentos son 3 o más -> "Cuenta bloqueada por seguridad".
- Si el usuario no existe -> "Usuario no encontrado". -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <h3>Ejercicio 2</h3>
    <h4>LOGIN</h4>
    <form action="" method="post">

        <label for="usuario">Usuario:</label><br>
        <input type="text" name="usuario" id="usuario" placeholder="usuario" required>
        <br><br>

        <label for="contrasenia">Contraseña:</label><br>
        <input type="password" name="contrasenia" id="contrasenia" placeholder="12345" required>
        <br><br>

        <button type="submit">VERIFICAR</button>

    </form>
    <br>

    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usuario"]) && isset($_POST["contrasenia"])) {
        $usuario = $_POST['usuario'];
        $contrasenia = $_POST['contrasenia'];

        if (!isset($_SESSION['intentos'])) {
            $_SESSION['intentos'] = 0;
        }

        if ($_SESSION['intentos'] >= 3) {
            echo "<b>Cuenta bloqueada</b> por seguridad";
        } else {
            if ($usuario == "usuario") {
                if ($contrasenia == 12345) {
                    echo "<b>Acceso permitido</b>";
                    $_SESSION['intentos'] = 0;
                } else {
                    $_SESSION['intentos']++;
                    if ($_SESSION['intentos'] >= 3) {
                        echo "<b>Cuenta bloqueada</b> por seguridad";
                    } else {
                        echo "<b>Contraseña incorrecta</b>, intentos restantes: <b>".(3 - $_SESSION['intentos'])."</b>";
                    }
                }
            } else {
                echo "Usuario <b>no encontrado</b>";
            }
        }
    }
    ?>
    <br><br>

    <a href="reset.php">VOLVER</a>
</body>
</html>