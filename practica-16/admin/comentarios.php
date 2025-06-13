<?php
include('../config/database.php');
include('../includes/auth.php');

if (isset($_GET['aprobar'])) {
    $id = $_GET['aprobar'];
    $conn->query("UPDATE comentarios SET aprobado = 1 WHERE id = $id");
    header("Location: comentarios.php");
}
if (isset($_GET['rechazar'])) {
    $id = $_GET['rechazar'];
    $conn->query("DELETE FROM comentarios WHERE id = $id");
    header("Location: comentarios.php");
}

$result = $conn->query("SELECT c.id, c.nombre, c.comentario, c.aprobado, p.titulo FROM comentarios c JOIN posts p ON c.post_id = p.id ORDER BY c.fecha_creacion DESC");

echo "<h2>Comentarios Pendientes</h2>";
while ($row = $result->fetch_assoc()) {
    echo "<div>
        <p><strong>{$row['nombre']}</strong> en <em>{$row['titulo']}</em></p>
        <p>{$row['comentario']}</p>
        <p>
            Estado: " . ($row['aprobado'] ? 'Aprobado' : 'Pendiente') . "<br>
            <a href='?aprobar={$row['id']}'>Aprobar</a> | 
            <a href='?rechazar={$row['id']}'>Eliminar</a>
        </p>
    </div><hr>";
}
?>