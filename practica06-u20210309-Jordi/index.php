<!-- Práctica 6.
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<?php include 'header.php'?>

<main>
    <section id="formulario">
        <h4>Ingrese la siguiente información:</h4>
        <form action="procesar.php" method="post">
            <label for="nombre">Nombre: </label>
            <input type="text" name="nombre" id="nombre" required>
            <br><br>
            <label for="color">Color favorito:</label>
            <select name="color" id="color">
                <option value="amarillo">amarillo</option>
                <option value="azul">azul</option>
                <option value="beige">beige</option>
                <option value="blanco">blanco</option>
                <option value="celeste">celeste</option>
                <option value="cyan">cyan</option>
                <option value="gris">gris</option>
                <option value="marron">marrón</option>
                <option value="morado">morado</option>
                <option value="naranja">naranja</option>
                <option value="negro">negro</option>
                <option value="lavanda">lavanda</option>
                <option value="lima">lima</option>
                <option value="oro">oro</option>
                <option value="plata">plata</option>
                <option value="rojo" selected>rojo</option>
                <option value="rosa">rosa</option>
                <option value="turquesa">turquesa</option>
                <option value="verde">verde</option>
                <option value="violeta">violeta</option>
            </select>
            <br><br>
            <button type="submit">INGRESAR</button>
        </form>
    </section>
</main>

<?php include 'footer.php'?>