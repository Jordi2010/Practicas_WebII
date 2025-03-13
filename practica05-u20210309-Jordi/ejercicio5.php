<!-- Práctica 5 (ejercicio 5)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- 5. Matrices en PHP. Inventario.
Ejercicio: declara una matriz bidimensional que represente un inventario con tres categorías (frutas,
verduras, bebidas) y tres productos por categoría. Llena la matriz con nombres de productos y precios.
Luego, calcula el total de cada categoría usando un bucle. -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 5</title>
</head>
<body>
    <h3>Ejercicio 5</h3>

    <?php
    $inventario = [
        'Frutas' => [
            'productos' => ['manzanas', 'naranjas', 'plátanos'],
            'precios' => [1.50, 1.00, 1.80]
        ],
        'Verduras' => [
            'productos' => ['zanahorias', 'lechugas', 'tomates'],
            'precios' => [1.00, 2.65, 0.75]
        ],
        'Bebidas' => [
            'productos' => ['agua', 'jugo', 'soda'],
            'precios' => [0.35, 0.65, 0.70]
        ]
    ];

    echo "<b>Resultado:</b><br><br>";

    echo "<table border='1'>";
    echo "<tr><th>Categoría</th><th>Producto</th><th>Precio</th></tr>";

    foreach ($inventario as $categoria => $detalle) {   // Iterar sobre las categorías
        $productos = $detalle['productos'];
        $precios = $detalle['precios'];

        for ($i = 0; $i < count($productos); $i++) {    // Iterar sobre los productos y precios de cada categoría
            echo "<tr>";
            echo "<td style='text-align: center;'>".$categoria."</td>";
            echo "<td style='text-align: center;'>".$productos[$i]."</td>";
            echo "<td style='text-align: center;'>$".$precios[$i]."</td>";
            echo "<tr>";
        }
    }

    echo "</table><br>";

    function calcularTotales($inventario) {     // Función para calcular el total de cada categoría
        foreach ($inventario as $categoria => $detalle) {
            $total = array_sum($detalle['precios']);        // Sumar los precios de cada categoría
            echo $categoria.": <b>$".$total."</b><br>";
        }
        return $total;
    }

    echo "<b>Total de cada categoría:</b><br><br>";
    calcularTotales($inventario);       // Llamada a las funciones para mostrar la tabla y los totales

    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>