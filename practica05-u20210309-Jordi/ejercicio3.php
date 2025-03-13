<!-- Práctica 5 (ejercicio 3)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- 3. Matrices en PHP. Tabla de multiplicar.
Ejercicio: crea un programa que genere una matriz bidimensional con las tablas de multiplicar del 1 al 10.
Cada fila debe representar una tabla y cada columna el resultado de multiplicar por los números del 1 al 10. -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 3</title>
</head>
<body>
    <h3>Ejercicio 3</h3>

    <?php
    echo "<b>Resultado:</b><br><br>";
    $tablas = [
        ["tabla" => 1, "numeros" => range(1, 10)],
        ["tabla" => 2, "numeros" => range(1, 10)],
        ["tabla" => 3, "numeros" => range(1, 10)],
        ["tabla" => 4, "numeros" => range(1, 10)],
        ["tabla" => 5, "numeros" => range(1, 10)],
        ["tabla" => 6, "numeros" => range(1, 10)],
        ["tabla" => 7, "numeros" => range(1, 10)],
        ["tabla" => 8, "numeros" => range(1, 10)],
        ["tabla" => 9, "numeros" => range(1, 10)],
        ["tabla" => 10, "numeros" => range(1, 10)]
    ];

    echo "<table border='1'>";
    echo "<tr><th>Tabla</th><th>x1</th><th>x2</th><th>x3</th><th>x4</th><th>x5</th><th>x6</th><th>x7</th><th>x8</th><th>x9</th><th>x10</th></tr>";

    foreach ($tablas as $tabla) {
        echo "<tr>";

        echo "<td style='text-align: center;'><b>".$tabla['tabla']."</b></td>";

        foreach ($tabla['numeros'] as $numero) {
            echo "<td style='text-align: center;'>".$tabla['tabla'] * $numero."</td>";
        }

        echo "<tr>";
    }

    echo "</table>";
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>