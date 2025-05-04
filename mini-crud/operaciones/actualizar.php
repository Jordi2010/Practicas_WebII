<!--Práctica 10
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Operación actualizar -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar producto</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        form { max-width: 500px; }
        .campo { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background-color: #2196F3; color: white; border: none; cursor: pointer; }
        a { display: inline-block; margin-top: 15px; }
    </style>
</head>
<body>
    <h1>Editar producto</h1>
    <form action="actualizar.php" method="post">
        <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">

        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $producto['nombre']; ?>" required>
        </div>

        <div>
            <label for="precio">Precio:</label>
            <input type="number" name="precio" id="precio" step="0.01" min="0" value="<?php echo $producto['precio']; ?>" required>
        </div>

        <div>
            <label for="stock">Stock:</label>
            <input type="number" name="stock" id="stock" min="0" value="<?php echo $producto['stock']; ?>" required>
        </div>

        <div>
            <label for="categoria">Categoría:</label>
            <select name="categoria_id" id="categoria" required>
                <?php
                foreach ($categorias as $categoria) {
                    $selected = ($producto['categoria_id'] == $categoria['id']) ? 'selected' : '';
                    echo "<option value=\"".$categoria['id']."\" selected>".$categoria['nombre']."</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit">Actualizar producto</button>
    </form>

    <a href="../index.php">Volver al listado</a>
</body>
</html>