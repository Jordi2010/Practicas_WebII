<!-- Práctica 5 (ejercicio 4)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- 4. Funciones avanzadas. Filtrar palabras.
Ejercicio: escribe una función llamada filtrarPalabras que reciba un arreglo de palabras y un número entero.
La función debe devolver sólo las palabras cuya longitud sea mayor al número recibido. -->

<?php
function filtrarPalabras($arrayPalabras, $numero) {
    $resultado = [];    // array para las palabras que cumplen la condición

    foreach ($arrayPalabras as $palabra) {
        $palabra = trim($palabra);      // se eliminan espacios extra
        if (strlen($palabra) > $numero) {
            $resultado[] = $palabra;
        }
    }

    // condicional para mostrar palabras que si cumplen la condición
    if (count($resultado) > 0) {
        return implode("<br>", $resultado);
    } else {
        return "No hay palabras con longitud mayor al número ingresado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4</title>
</head>
<body>
    <h3>Ejercicio 4</h3>
    <form action="" method="post">
        <label for="arrayPalabras"><b>Ingrese una o más palabras (separadas por comas): </b></label>
        <input type="text" name="arrayPalabras" id="arrayPalabras" placeholder="Ej: palabra1, palabra2..." required>
        <br><br>
        <label for="numero"><b>Ingrese la longitud a la cual deben ser mayor cada palabra: </b></label>
        <input type="number" name="numero" id="numero" min="0" placeholder="longitud en número" required>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['arrayPalabras']) && isset($_POST['numero'])) {
        $arrayPalabras = $_POST['arrayPalabras'];
        $numero = $_POST['numero'];
        $arrayPalabras = explode(",", $arrayPalabras);
        
        echo filtrarPalabras($arrayPalabras, $numero);
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>