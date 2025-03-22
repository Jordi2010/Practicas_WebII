<!-- Práctica 6.
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<?php include 'header.php';?>

<main>
    <?php
    echo "<b>Resultado:</b><br><br>";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = $_POST['nombre'];
        $color = $_POST['color'];

        if (!empty($nombre) && !empty($color)) {
            $mensaje = "Tu nombre es <b>".$nombre."</b> y tu color favorito es <b>".$color."</b>.";
        } else {
            $mensaje = "¡Error! ingrese correctamente los datos.";
        }
    } else {
        $mensaje = "¡ERROR!";
    }
    echo $mensaje;
    ?>
</main>

<?php include 'footer.php';?>