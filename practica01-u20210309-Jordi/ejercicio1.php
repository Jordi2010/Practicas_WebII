<!-- Práctica 1 (ejercicio 1).
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 1: calculadora básica.
Desarrollar un formulario con:
• Dos campos para número.
• Un selector para la operación (+, -, *, /).
• Mostrar el resultado de la operación seleccionada.-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h3>Ejercicio 1</h3>
    <h4>Ingresar los siguientes datos:</h4>
    <form method="post">
        <label for="numero1">Primer número:</label><br>
        <input type="number" name="numero1" id="numero1" placeholder="Valor numérico entero" required>
        <br><br>
        <label for="numero2">Segundo número:</label><br>
        <input type="number" name="numero2" id="numero2" placeholder="Valor numérico entero" required>
        <br><br>
        <label for="operacion">Selecciona la operación:</label><br>
        <select name="operacion" id="operacion">
            <option value="suma">Suma +</option>
            <option value="resta">Resta -</option>
            <option value="multiplicacion">Multiplicación *</option>
            <option value="division">División /</option>
        </select>
        <br><br>
        <button type="submit">CALCULAR</button>
    </form>
    <br>

    <?php
    echo "Resultado: ";
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['numero1']) && isset($_POST['numero2']) && isset($_POST['operacion'])) {
        $numero1 = $_POST['numero1'];
        $numero2 = $_POST['numero2'];
        $operacion = $_POST['operacion'];

        if ($operacion == "suma") {
            $resultado = $numero1 + $numero2;
        } else if ($operacion == "resta") {
            $resultado = $numero1 - $numero2;
        } else if ($operacion == "multiplicacion") {
            $resultado = $numero1 * $numero2;
        } else if ($operacion == "division") {
            $resultado = $numero1 / $numero2;
        } else {
            $resultado = "ERROR";
        }

        echo "<strong>".$resultado."</strong>";
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>