<!-- Práctica 3 (ejercicio 2)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 2: verificar si una cadena es palíndrome.
Este ejercicio requiere crear una función esPalindrome que reciba una cadena y devuelva verdadero si es
un palindrome (lee igual de adelante hacia atrás y viceversa, ignorando espacios y mayúsculas/minúsculas,
por ejemplo, "radar"). Incluye un formulario HTML para ingresar la cadena y mostrar el resultado.-->

<?php
function esPalindrome($cadena) {
    // convirtiendo la cadena a minúsculas y quitando los espacios
    $cadena = strtolower(str_replace(' ', '', $cadena));

    // invertiendo la cadena
    $cadenaInvertida = strrev($cadena);

    // comparando la cadena original con la invertida
    return $cadena === $cadenaInvertida;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 2</title>
</head>
<body>
    <h3>Ejercicio 2</h3>
    <form action="" method="post">
        <label for="cadena"><b>Ingrese una cadena de texto:</b></label>
        <input type="text" name="cadena" id="cadena" required>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    // Proceso del formulario cuando se envía
    echo "<b>Resultado:</b><br><br>";
    $resultado = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cadena"])) {
        $cadena = $_POST['cadena'];         // obteniendo la cadena ingresada

        if (esPalindrome($cadena)) {
            $resultado = "<b>Verdadero</b>, la cadena <b>".$cadena."</b> SI es palíndrome.";
        } else {
            $resultado = "<b>Falso</b>, la cadena <b>".$cadena."</b> NO es palíndrome.";
        }

        if ($resultado !== "") {
            echo $resultado;
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>