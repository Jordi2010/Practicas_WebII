<!-- Práctica 4 (ejercicio 1)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 1: función recursiva para sumar elementos de una matriz.
Escribe una función recursiva que calcule la suma de todos los elementos de una matriz 2x2.
    • Crear formulario.
    • Recibir los datos del formulario por método post. -->

<?php
function sumaMatricesRecursiva($matriz, $fila = 0, $columna = 0) {
    // caso base
    if ($fila >= 2) {
        return 0;
    }
    $actual = $matriz[$fila][$columna];
    if ($columna < 1) {
        return $actual + sumaMatricesRecursiva($matriz, $fila, $columna + 1);
    } else {
        return $actual + sumaMatricesRecursiva($matriz, $fila + 1, 0);
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
            
            $suma = sumaMatricesRecursiva($matriz);
            echo "La suma de los elementos de la matriz es: <b>".$suma."</b>";
        } else {
            echo "<b>¡ERROR!</b> debe ingresar exactamente 4 números separados por comas.";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>