<?php
include('../config/database.php');
include('../includes/auth.php');

if (isset($_POST['crear'])) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $slug = $_POST['slug'];
    $conn->query("INSERT INTO categorias (nombre, descripcion, slug) VALUES ('$nombre', '$descripcion', '$slug')");
    header("Location: categorias.php");
}
if (isset($_GET['eliminar'])) {
    $conn->query("DELETE FROM categorias WHERE id = " . $_GET['eliminar']);
    header("Location: categorias.php");
}
if (isset($_POST['editar'])) {
    $conn->query("UPDATE categorias SET nombre = '{$_POST['nombre']}', descripcion = '{$_POST['descripcion']}', slug = '{$_POST['slug']}' WHERE id = {$_POST['id']}");
    header("Location: categorias.php");
}

$result = $conn->query("SELECT c.*, COUNT(p.id) AS total FROM categorias c LEFT JOIN posts p ON p.categoria_id = c.id GROUP BY c.id");
?>

<h2>Categorías</h2>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nueva categoría" required>
    <input type="text" name="descripcion" placeholder="Nueva descripción" required>
    <input type="text" name="slug" placeholder="Nuevo slug" required>
    <button name="crear">Agregar</button>
</form>

<?php while ($cat = $result->fetch_assoc()): ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
        <input type="text" name="nombre" value="<?= $cat['nombre'] ?>">
        <input type="text" name="descripcion" value="<?= $cat['descripcion'] ?>">
        <input type="text" name="slug" value="<?= $cat['slug'] ?>">
        <button name="editar">Editar</button>
        <a href="?eliminar=<?= $cat['id'] ?>">Eliminar</a>
        <span>(<?= $cat['total'] ?> posts)</span>
    </form>
<?php endwhile; ?>