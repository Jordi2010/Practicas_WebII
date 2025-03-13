<!-- Práctica 5 (ejercicio 2)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- 2. Funciones avanzadas. Ordenar arreglo.
Ejercicio: escribe una función llamada ordenarArreglo que reciba un arreglo de números y lo ordene de
forma ascendente o descendente según un segundo parrámetro ("asc" o "desc"). Usa funciones de ordenamiento
como sort o rsort. -->

<?php
function ordenarArreglo($arrayNumeros, $orden) {
    //return ($orden == "asc") ? sort($arrayNumeros) && "Orden ascendente: ".implode(" - ", $arrayNumeros) : (($orden == "desc") ? rsort($arrayNumeros) && "Orden descendente: ".implode(" - ", $arrayNumeros) : "¡ERROR! debe seleccionar el orden.");
    if ($orden == "asc") {
        sort($arrayNumeros);
        return "Orden ascendente: <b>".implode(" - ", $arrayNumeros)."</b>";
    } else if ($orden == "desc") {
        rsort($arrayNumeros);
        return "Orden descendente: <b>".implode(" - ", $arrayNumeros)."</b>";
    } else {
        return "<b>¡ERROR!</b> debe seleccionar el orden.";
    }
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
        <label for="arrayNumeros"><b>Ingrese números (separados por coma): </b></label>
        <input type="text" name="arrayNumeros" id="arrayNumeros" placeholder="Ej: 1,2,3,4,5..." required>
        <br><br>
        <label for="orden"><b>Seleccione el orden del resultado:</b></label><br>
        <input type="radio" name="orden" id="orden" value="asc" checked>Ascendente<br>
        <input type="radio" name="orden" id="orden" value="desc">Descendente<br>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['arrayNumeros']) && isset($_POST['orden'])) {
        $arrayNumeros = $_POST['arrayNumeros'];
        $orden = $_POST['orden'];
        $arrayNumeros = explode(",", $arrayNumeros);

        foreach ($arrayNumeros as $numero) {
            if (is_numeric(trim($numero))) {
                $arrayNumeros = array_map('doubleval', $arrayNumeros);
                echo ordenarArreglo($arrayNumeros, $orden);
                break;
            } else {
                echo "<b>¡ERROR!</b> ingrese solo números separados por comas.";
                break;
            }
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>