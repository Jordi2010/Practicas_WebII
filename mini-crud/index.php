<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Página principal -->

<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "mini_crud");
// Verifica conexión
if (!$conexion) {
    die("Error de conexión: ".mysqli_connect_error());
}
// Consulta productos
$sql = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini CRUD - Productos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th {background-color: #f2f2f2; }
        .acciones { display: flex; gap: 5px; }
        .btn { padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .btn-crear { background-color: #4CAF50; }
        .btn-editar { background-color: #2196F3; }
        .btn-eliminar { background-color: #f44336; }
    </style>
</head>
<body>
    <h1>Gestión de productos</h1>
    <a href="crear_formulario.php">Nuevo producto</a>
    <hr>

    <h2>Lista de productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Categoría</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($resultado) > 0) {
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td>".$fila["id"]."</td>";
                    echo "<td>".$fila["nombre"]."</td>";
                    echo "<td>".$fila["precio"]."</td>";
                    echo "<td>".$fila["stock"]."</td>";
                    echo "<td>".$fila["categoria"]."</td>";
                    echo "<td> class='acciones'>";
                    echo "<a href='operaciones/actualizar.php?id=".$fila["id"]."'>Editar</a>";
                    echo "<a href='operaciones/eliminar.php?id=".$fila["id"]."'>Eliminar</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>