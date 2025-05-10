<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo libro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1 {
            color: #333;
        }
        .formulario {
            max-width: 600px;
            margin: 20px 0;
        }
        .campo {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .error-campo {
            color: #721c24;
            font-size: 14px;
            margin-top: 5px;
        }
        .mensaje {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .botones {
            margin-top: 20px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Registrar nuevo libro</h1>
    <?php
    if (!empty($errores)) {
        echo 'div class="mensaje error">';
        echo '<p><strong>Por favor, corrija los siguientes errores:</strong></p>';
        echo '<ul>';
        foreach ($errores as $campo => $mensaje) {
            echo '<li>'.htmlspecialchars($mensaje).'</li>';
        }
        echo '</ul>';
        echo '';
    }

    // Recuperar valores previamente ingresados si existen
    $valores = [];
    if (isset($_GET['valores'])) {
        $valores = json_decode(urldecode($_GET['valores']), true);
    }
    ?>

    <form class="formulario" action="libro_procesar.php" method="post">
        <div>
            <label for="titulo">Título *</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo isset($valores['titulo']) ? htmlspecialchars($valores['titulo']) : ''; ?>" required>
        </div>

        <div>
            <label for="autor">Autor *</label>
            <input type="text" name="autor" id="autor" value="<?php echo isset($valores['autor']) ? htmlspecialchars($valores['autor']) : ''; ?>" required>
        </div>

        <div>
            <label for="isbn">ISBN *</label>
            <input type="text" name="isbn" id="isbn" value="<?php echo isset($valores['isbn']) ? htmlspecialchars($valores['isbn']) : ''; ?>" placeholder="Ej: 978-3-16-148410-0" required>
        </div>

        <div>
            <label for="paginas">Número de páginas</label>
            <input type="number" name="paginas" id="paginas" value="<?php echo isset($valores['paginas']) ? htmlspecialchars($valores['paginas']) : ''; ?>" min="1">
        </div>

        <div>
            <label for="fecha_publicacion">Fecha de publicación</label>
            <input type="date" name="fecha_publicacion" id="fecha_publicacion" value="<?php echo isset($valores['fecha_publicacion']) ? htmlspecialchars($valores['fecha_publicacion']) : ''; ?>">
        </div>

        <div>
            <label for="ejemplares">Número de ejemplares *</label>
            <input type="number" name="ejemplares" id="ejemplares" value="<?php echo isset($valores['ejemplares']) ? htmlspecialchars($valores['ejemplares']) : '1'; ?>" min="1" required>
        </div>

        <div>
            <button type="submit">Guardar libro</button>
        </div>
    </form>

    <a href="index.php">Volver al inicio</a>
</body>
</html>