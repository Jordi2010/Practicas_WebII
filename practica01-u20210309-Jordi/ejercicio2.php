<!-- Práctica 1 (ejercicio 2).
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 2: sistema de calificaciones.
Crear un formulario que permita ingresar las calificaciones de un estudiante:
• Nombre del estudiante.
• Calificaciones de 4 materias diferentes (matemáticas, español, historia, ciencias).
Al procesar el formulario, debe:
• Calcular el promedio.
• Determinar si está aprobado.
• Mostrar la materia con mejor y peor calificación.-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <h3>Ejercicio 2</h3>
    <h4>Ingresar los siguientes datos:</h4>
    <form method="post">
        <label for="nombre">Nombre de estudiante:</label><br>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" required>
        <br><br>
        <label for="matematicaNota">Calificación de matemática:</label><br>
        <input type="number" name="matematicaNota" id="matematicaNota" step="0.1" min="0" max="10" placeholder="0 - 10" required>
        <br><br>
        <label for="espaniolNota">Calificación de español:</label><br>
        <input type="number" name="espaniolNota" id="espaniolNota" step="0.1" min="0" max="10" placeholder="0 - 10" required>
        <br><br>
        <label for="historiaNota">Calificación de historia:</label><br>
        <input type="number" name="historiaNota" id="historiaNota" step="0.1" min="0" max="10" placeholder="0 - 10" required>
        <br><br>
        <label for="cienciaNota">Calificación de ciencia:</label><br>
        <input type="number" name="cienciaNota" id="cienciaNota" step="0.1" min="0" max="10" placeholder="0 - 10" required>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "Promedio: ";
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['nombre']) && isset($_POST['matematicaNota']) && isset($_POST['espaniolNota']) && isset($_POST['historiaNota']) && isset($_POST['cienciaNota'])) {
        $nombre = $_POST['nombre'];
        $matematicaNota = $_POST['matematicaNota'];
        $espaniolNota = $_POST['espaniolNota'];
        $historiaNota = $_POST['historiaNota'];
        $cienciaNota = $_POST['cienciaNota'];

        echo "<strong>".$promedio = ($matematicaNota + $espaniolNota + $historiaNota + $cienciaNota) / 4 ."</strong><br>";

        if ($promedio >= 7) {
            echo "Ha <strong>aprobado</strong><br>";
        } else {
            echo "Ha <strong>reprobado</strong><br>";
        }

        if ($matematicaNota == $espaniolNota && $matematicaNota ==  $historiaNota && $matematicaNota == $cienciaNota) {
            echo "Todas las materias de <strong>".$nombre."</strong> tienen la misma nota (".$matematicaNota.")";
        } else if ($matematicaNota > $espaniolNota && $matematicaNota > $historiaNota && $matematicaNota > $cienciaNota) {
            echo "La materia con <strong>mejor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>matemática (".$matematicaNota.")</strong><br>";
        } else if ($espaniolNota > $matematicaNota && $espaniolNota > $historiaNota && $espaniolNota > $cienciaNota) {
            echo "La materia con <strong>mejor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>español (".$espaniolNota.")</strong><br>";
        } else if ($historiaNota > $matematicaNota && $historiaNota > $espaniolNota && $historiaNota > $cienciaNota) {
            echo "La materia con <strong>mejor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>historia (".$historiaNota.")</strong><br>";
        } else if ($cienciaNota > $matematicaNota && $cienciaNota > $espaniolNota && $cienciaNota > $historiaNota) {
            echo "La materia con <strong>mejor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>ciencia (".$cienciaNota.")</strong><br>";
        }

        if ($matematicaNota < $espaniolNota && $matematicaNota < $historiaNota && $matematicaNota < $cienciaNota) {
            echo "La materia con <strong>peor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>matemática (".$matematicaNota.")</strong>";
        } else if ($espaniolNota < $matematicaNota && $espaniolNota < $historiaNota && $espaniolNota < $cienciaNota) {
            echo "La materia con <strong>peor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>español (".$espaniolNota.")</strong>";
        } else if ($historiaNota < $matematicaNota && $historiaNota < $espaniolNota && $historiaNota < $cienciaNota) {
            echo "La materia con <strong>peor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>historia (".$historiaNota.")</strong>";
        } else if ($cienciaNota < $matematicaNota && $cienciaNota < $espaniolNota && $cienciaNota < $historiaNota) {
            echo "La materia con <strong>peor</strong> calificación de <strong>".$nombre."</strong> fue: <strong>ciencia (".$cienciaNota.")</strong>";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>