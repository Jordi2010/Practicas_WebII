<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Crear producto -->

<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "usuario", "contraseña", "basedatos");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
// Obtener categorías
$sql = "SELECT id, nombre FROM categorias";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; }
        .campo { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Crear nuevo producto</h1>

    <form action="operaciones/crear.php" method="post">
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" required>
        </div>

        <div>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" step="0.01" min="0" required>
        </div>

        <div>
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" min="0" required>
        </div>

        <div>
            <label for="categoria">Categoría:</label>
            <select name="categoria_id" id="categoria" required>
                <option value="">Seleccione una categoría</option>
                <?php
                if (mysqli_num_rows($resultado) > 0) {
                    while ($categoria = mysqli_fetch_assoc($resultado)) {
                        echo "<option value='".$categoria['id']."'>".$categoria['nombre']."</option>";
                    }
                }
                ?>
            </select>
        </div>

        <button type="submit">Guardar producto</button>
    </form>

    <a href="index.php">Volver al listado</a>
</body>
</html>