<?php
// Ejercicio 1: Inyección SQL (SQLi)
// EJERCICIO: corregir esta vulnerabilidad
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('localhost', 'root', '', 'test');

    $id = $_POST['id'];

    // ¡Vulnerabilidad de SQLi!
    $query = "SELECT * FROM usuarios WHERE id = $id";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        echo "Usuario encontrado: ".$result->fetch_assoc()['usuario'];
    } else {
        echo "Usuario no encontrado";
    }
}
?>

<form action="" method="post">
    ID de usuario: <input type="number" name="id">
    <button type="submit">Buscar</button>
</form>

<a href="../../index.php" class="back-link">Volver al inicio</a>

<!--
Instrucciones:
1. Identificar la vulnerabilidad SQLi
2. Modificar el código usando consultas preparadas
3. Probar con entrada: 1 OR 1=1
4. Validar que ya no muestra todos los usuarios
-->