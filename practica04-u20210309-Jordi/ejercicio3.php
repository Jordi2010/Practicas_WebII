<!-- Práctica 4 (ejercicio 3)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 3: función de orden superior para operar matrices.
Desarrolla una función de orden superior que reciba dos matrices 2x2 y una función callback que defina una
operación (como suma o resta) sobre sus elementos.
    • Crear un formulario.
    • Recibir los datos del formulario por método post. -->

<?php
function aplicarOperacion($matriz1, $matriz2, $operacion) {
    $resultado = [];
    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < 2; $j++) {
            $resultado[$i][$j] = $operacion($matriz1[$i][$j], $matriz2[$i][$j]);
        }
    }
    return $resultado;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <h3>Ejercicio 3</h3>
    <form action="" method="post">
    <label for="matriz1"><b>Ingrese la 1ra matriz 2x2 (4 números separados por coma):</b></label>
    <input type="text" name="matriz1" id="matriz1" placeholder="Ej: 1,2,3,4" required>
    <br><br>
    <label for="matriz2"><b>Ingrese la 2da matriz 2x2 (4 números separados por coma):</b></label>
    <input type="text" name="matriz2" id="matriz2" placeholder="Ej: 1,2,3,4" required>
    <br><br>
    <label for="operacion"><b>Selecciona la operación a realizar:</b></label>
    <select name="operacionSeleccionada" id="operacionSeleccionada">
        <option value="suma" selected>Suma</option>
        <option value="resta">Resta</option>
        <option value="multiplicacion">Multiplicación</option>
        <option value="division">División</option>
    </select>
    <br><br>
    <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matriz1']) && isset($_POST['matriz2']) && isset($_POST['operacionSeleccionada'])) {
        $entrada1 = $_POST['matriz1'];
        $entrada2 = $_POST['matriz2'];
        $numeros1 = explode(",", $entrada1);
        $numeros2 = explode(",", $entrada2);
        $operacionSeleccionada = $_POST['operacionSeleccionada'];

        if (count($numeros1) == 4 && count($numeros2) == 4) {

            $matriz1 = [];
            foreach (array_chunk($numeros1, 2) as $i => $fila) {
                $matriz1[$i] = array_map('floatval', $fila);
            }
            $matriz2 = [];
            foreach (array_chunk($numeros2, 2) as $i => $fila) {
                $matriz2[$i] = array_map('floatval', $fila);
            }

            if ($operacionSeleccionada == "suma") {
                $operacion = function($numero1, $numero2) {
                    return $numero1 + $numero2;
                };
            } else if ($operacionSeleccionada == "resta") {
                $operacion = function($numero1, $numero2) {
                    return $numero1 - $numero2;
                };
            } else if ($operacionSeleccionada == "multiplicacion") {
                $operacion = function($numero1, $numero2) {
                    return $numero1 * $numero2;
                };
            } else if ($operacionSeleccionada == "division") {
                $operacion = function($numero1, $numero2) {
                    if ($numero2 != 0) {
                        return $numero1 / $numero2;
                    } else {
                        echo "No se puede dividir por cero.<br>";
                    }
                };
            }

            $operar = aplicarOperacion($matriz1, $matriz2, $operacion);
            print_r($operar);
        } else {
            echo "¡ERROR! debe ingresar exactamente 4 números separados por comas.";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>