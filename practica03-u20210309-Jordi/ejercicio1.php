<!-- Práctica 3 (ejercicio 1)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 1: contar vocales en una palabra.
Crea una función en PHP llamada contarVocales que reciba una cadena de texto y devuelva la cantidad de
vocales (a, e, i, o, u, sin importar mayúsculas o minúsculas) que contiene. Luego, crea un formulario HTML
que permita ingresar una palabra y mostrar el número de vocales encontradas. -->

<?php
function contarVocales($palabra) {
    // inicializando los contadores para cada vocal
    $vocales = 0;
    $contadorA = 0;
    $contadorE = 0;
    $contadorI = 0;
    $contadorO = 0;
    $contadorU = 0;
    // convertir toda palabra a minúsculas
    $palabra = strtolower($palabra);

    // recorriendo cada letra de la palabra
    for ($i = 0; $i < strlen($palabra); $i++) {
        $letra = $palabra[$i];    // obteniendo cada letra de la palabra

        // verificando si la letra es una vocal
        if ($letra == "a") {
            $vocales++;
            $contadorA++;
        } else if ($letra == "e") {
            $vocales++;
            $contadorE++;
        } else if ($letra == "i") {
            $vocales++;
            $contadorI++;
        } else if ($letra == "o") {
            $vocales++;
            $contadorO++;
        } else if ($letra == "u") {
            $vocales++;
            $contadorU++;
        }
    }
    // devolviendo un array con los resultados de las vocales
    return [
        'vocales' => $vocales,
        'a' => $contadorA,
        'e' => $contadorE,
        'i' => $contadorI,
        'o' => $contadorO,
        'u' => $contadorU
    ];
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
        <label for="palabra"><b>Ingrese una palabra:</b></label>
        <input type="text" name="palabra" id="palabra" required>
        <!--<input type="text" name="palabra" id="palabra" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ]+" title="Solo se permiten letras" required>-->
        <br><br>
        <button type="submit">INGRESAR</button>
    </form>
    <br>

    <?php
    // Proceso del formulario cuando se envía
    echo "<b>Resultado:</b><br><br>";
    if (isset($_POST['palabra'])) {
        $palabraIngresada = $_POST['palabra'];      // obteniendo la palabra ingresada

        if (!empty($palabraIngresada)) {         // verificando si la palabra no está vacía
            
            $numVocales = contarVocales($palabraIngresada);    // contando las vocales
            
            // mostrando resultados
            echo "Palabra: <b>".$palabraIngresada."</b><br>";
            echo "No. de vocales: <b>".$numVocales['vocales']."</b><br><br>";
            echo "Cant. de a: <b>".$numVocales['a']."</b><br>";
            echo "Cant. de e: <b>".$numVocales['e']."</b><br>";
            echo "Cant. de i: <b>".$numVocales['i']."</b><br>";
            echo "Cant. de o: <b>".$numVocales['o']."</b><br>";
            echo "Cant. de u: <b>".$numVocales['u']."</b><br>";
        } else {
            echo "Por favor ingrese una palabra válida.";
        }
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>