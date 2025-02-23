<!-- Práctica 2 (ejercicio 1)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 1. Calculadora de envíos.
Calcula el costo de envío según estas reglas:
- Si el peso es menor a 1 kg -> $10.
- Si el peso está entre 1 kg y 5 kg -> $20.
- Si el peso está entre 5 kg y 10 kg -> $30.        NOTA: tiene que ser 6 el mínimo ya que el 5 es condición de la regla anterior.
- Si el peso es mayor a 10 kg -> $50.

Además:
- Si el destino es internacional, multiplica el costo por 2.
- Si es envío express, suma $15 adicionales.
- Si el cliente es premium, aplica 10% de descuento al total. -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
</head>
<body>
    <h3>Ejercicio 1</h3>
    <h4>Complete lo que se solicita a continuación:</h4>
    <form action="" method="post">

        <label for="peso"><b>Peso (kg):</b></label>
        <input type="number" name="peso" id="peso" step="0.01" min="0" required>
        <br><br>

        <label for="destino"><b>Destino:</b></label>
        <select name="destino" id="destino">
            <option value="nacional">Nacional</option>
            <option value="internacional">Internacional</option>
        </select>
        <br><br>

        <label for="envio"><b>Envío:</b></label><br>
        <input type="radio" name="envio" id="envio" value="normal" checked>Normal<br>
        <input type="radio" name="envio" id="envio" value="express">Express
        <br><br>

        <label for="cliente">Cliente premium: </label>
        <input type="checkbox" name="cliente" id="cliente">
        <br><br>

        <button type="submit">INGRESAR</button>
        
    </form>
    <br>

    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["peso"]) && isset($_POST["destino"])) {
        $peso = $_POST['peso'];
        $destino = $_POST['destino'];
        $envio = $_POST['envio'];

        $cliente = isset($_POST['cliente']) ? "premium" : "normal";

        echo "Peso: <b>".$peso." kg</b><br>";

        if ($peso < 1) {
            $costo = 10;
        } else if ($peso >= 1 && $peso <= 5) {
            $costo = 20;
        } else if ($peso >= 6 && $peso <= 10) {
            $costo = 30;
        } else {
            $costo = 50;
        }
        echo "Costo: <b>$".$costo."</b><br>";

        if ($destino == "internacional") {
            $costo *= 2;
        }
        // $costo *= ($destino == "internacional") ? 2;
        echo "Destino: <b>".$destino."</b><br>";

        if ($envio == "express") {
            $costo += 15;
        }
        echo "Envío: <b>".$envio."</b><br>";

        if ($cliente == "premium") {
            $costo -= $costo * 0.1;
        }
        echo "Cliente: <b>".$cliente."</b><br>";

        echo "Costo TOTAL de envío: <b>$".round($costo, 2)."</b>";
    }
    ?>
    <br><br>

    <a href="./index.php">VOLVER</a>
</body>
</html>