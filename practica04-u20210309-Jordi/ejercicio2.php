<!-- Práctica 4 (ejercicio 2)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 2: función anónima para transformar una matriz.
Crea una función anónima que tome una matriz 2x2 y devuelva una nueva matriz donde cada elemento se
multiplique por 2.
    • Crear un formulario.
    • Recibir los datos del formulario por método post. -->

<?php
$dobleMatriz = function($matriz) {
    $resultado = [];
    for ($i = 0; $i < 2; $i++) {
        for ($j = 0; $j < 2; $j++) {
            $resultado[$i][$j] = $matriz[$i][$j] * 2;
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
    <title>Ejercicio 2</title>
</head>
<body>
    <h3>Ejercicio 2</h3>
    <form action="" method="post">
        <label for="matriz"><b>Ingrese una matriz 2x2 (4 números separados por coma):</b></label>
        <input type="text" name="matriz" id="matriz" placeholder="Ej: 1,2,3,4" required>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['matriz'])) {
        $entrada = $_POST['matriz'];
        $numeros = explode(",", $entrada);

        if (count($numeros) == 4) {
            
            $matriz = [];
            foreach (array_chunk($numeros, 2) as $i => $fila) {
                $matriz[$i] = array_map('floatval', $fila);
            }

            $doble = $dobleMatriz($matriz);
            print_r($doble);
        } else {
            echo "<b>¡ERROR!</b> debe ingresar exactamente 4 números separados por comas.";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>