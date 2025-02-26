<!-- Práctica 3 (ejercicio 3)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 3: sumar números pares hasta un número dado.
Crea una función sumarPares que sume todos los números pares desde 1 hasta un número dado, incluyendo
este si es par. Incluye un formulario HTML para ingresar el número y mostrar la suma. -->

<?php
function sumarPares($numero) {
    $suma = 0;

    // sumando los números pares desde 2 hasta el número dado
    for ($i = 2; $i <= $numero; $i += 2) {
        $suma += $i;
    }
    return $suma;
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
        <label for="numero"><b>Ingrese un número</b></label>
        <input type="number" name="numero" id="numero" required>
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    // Procensando el formulario
    if (isset($_POST["numero"])) {
        $numero = $_POST['numero'];

        if ($numero > 0) {
            $resultado = sumarPares($numero);
            echo "La suma de los números pares hasta ".$numero." es: <b>".$resultado."</b>";
        } else {
            echo "Por favor, ingrese un número mayor que 0.";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>