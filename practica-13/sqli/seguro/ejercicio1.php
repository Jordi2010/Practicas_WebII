<?php
// Ejercicio 1: Inyección SQL (SQLi)
// SOLUCIÓN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('localhost', 'root', '', 'test');

    $id = $_POST['id'];

    // ¡Vulnerabilidad de SQLi! -> Solucionada con prepared statements
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);    // "i" indica que el parámetro es un entero
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Usuario encontrado: ".$result->fetch_assoc()['usuario'];
    } else {
        echo "Usuario no encontrado";
    }

    $stmt->close();
    $db->close();
}
?>

<form action="" method="post">
    ID de usuario: <input type="number" name="id">
    <button type="submit">Buscar</button>
</form>

<a href="../../index.php" class="back-link">Volver al inicio</a>