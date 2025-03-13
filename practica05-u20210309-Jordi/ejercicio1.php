<!-- Práctica 5 (ejercicio 1)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- 1. Funciones en PHP. Verificar edad.
Ejercicio: crea una función llamada verificarEdad que reciba como parámetro la edad de una persona y
devuelva un mensaje indicando si es mayor o menor de edad. -->

<?php
function verificarEdad($edad) {
    //return ($edad >= 18) ? "Eres mayor de edad (".$edad.")." : (($edad < 18 && $edad > 0) ? "Eres menor de edad (".$edad.")" : "¡ERROR! ingresa un valor numérico mayor a 0.");
    if ($edad >= 18) {
        return "Eres <b>mayor de edad</b> (".$edad.").";
    } else if ($edad < 18 && $edad > 0) {
        return "Eres <b>menor de edad</b> (".$edad.").";
    } else {
        return "<b>¡ERROR!</b> ingrese un valor numérico mayor a 0.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h3>Ejercicio 1</h3>
    <form action="" method="post">
        <label for="edad"><b>Ingrese la edad: </b></label>
        <input type="number" name="edad" id="edad" min="1" placeholder="número de años">
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edad'])) {
        $edad = $_POST['edad'];

        echo verificarEdad($edad);
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>