<?php
require_once 'conexion/db.php';
require_once 'validacion/funciones.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar nuevo préstamo</title>
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
    <h1>Registrar nuevo préstamo</h1>

    <?php
    // Mostrar errores si vienen de un intento anterior
    if (isset($_GET['errores'])) {
        $errores = json_decode(urldecode($_GET['errores']), true);
        echo '<div class="mensaje error">';
        echo '<p><strong>Por favor, corrija los siguientes errores:</strong></p>';
        echo '<ul>';
        foreach ($errores as $campo => $mensaje) {
            echo '<li>'.htmlspecialchars($mensaje).'</li>';
        }
        echo '</ul>';
        echo '</div>';
    }

    // Recuperar valores previamente ingresados si existen
    $valores = [];
    if (isset($_GET['valores'])) {
        $valores = json_decode(urldecode($_GET['valores']), true);
    }

    // Verificar libros disponibles
    try {
        $stmt = $conexion->query("SELECT l.id, l.titulo, l.autor, l.ejemplares,
        (l.ejemplares - COUNT(CASE WHEN p.estado = 'prestado' THEN 1 END)) as disponibles
        FROM libros l
        LEFT JOIN prestamos p ON l.id = p.libro_id
        GROUP BY l.id
        HAVING disponibles > 0
        ORDER BY l.titulo");

        $hayLibrosDisponibles = ($stmt->rowCount() > 0);
    } catch(PDOException $e) {
        echo '<div class="mensaje error">Error al cargar libros disponibles: '.$e->getMessage().'</div>';
        $hayLibrosDisponibles = false;
    }
    ?>

    <?php if ($hayLibrosDisponibles): ?>
    <form class="formulario" action="prestamo_procesar.php" method="post">
        <div class="campo">
            <label for="libro_id">Libro *</label>
            <select name="libro_id" id="libro_id" required>
                <option value="">Seleccione un libro</option>
                <?php
                while ($libro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $selected = (isset($valores['libro_id']) && $valores['libro_id'] == $libro['id']) ? 'selected' : '';
                    echo "<option value='".$libro['id']."' $selected>".
                    htmlspecialchars($libro['titulo'])." (".
                    htmlspecialchars($libro['autor']).") - ".
                    $libro['disponibles']." disponible(s)</option>";
                }
                ?>
            </select>
            <?php if (isset($errores['libro_id'])): ?>
                <div class="error-campo"><?php echo htmlspecialchars($errores['libro_id']); ?></div>
                <?php endif; ?>
        </div>

        <div class="campo">
            <label for="nombre_lector">Nombre del lector *</label>
            <input type="text" name="nombre_lector" id="nombre_lector" value="<?php echo isset($valores['nombre_lector']) ? htmlspecialchars($valores['nombre_lector']) : ''; ?>" required>
            <?php if (isset($errores['nombre_lector'])): ?>
                <div class="error-campo"><?php echo htmlspecialchars($errores['nombre_lector']); ?></div>
                <?php endif; ?>
        </div>

        <div class="campo">
            <label for="email">Email del lector *</label>
            <input type="email" name="email" id="email" value="<?php echo isset($valores['email']) ? htmlspecialchars($valores['email']) : ''; ?>" required>
            <?php if (isset($errores['email'])): ?>
                <div class="error-campo"><?php echo htmlspecialchars($errores['email']); ?></div>
                <?php endif; ?>
        </div>

        <div class="campo">
            <label for="fecha_prestamo">Fecha de préstamo *</label>
            <input type="date" name="fecha_prestamo" id="fecha_prestamo" value="<?php echo isset($valores['fecha_prestamo']) ? htmlspecialchars($valores['fecha_prestamo']) : date('Y-m-d'); ?>" required>
            <?php if (isset($errores['fecha_prestamo'])): ?>
                <div class="error-campo"><?php echo htmlspecialchars($errores['fecha_prestamo']); ?></div>
                <?php endif; ?>
        </div>

        <div class="campo">
            <label for="fecha_devolucion">Fecha de devolución *</label>
            <input type="date" name="fecha_devolucion" id="fecha_devolucion" value="<?php echo isset($valores['fecha_devolucion']) ? htmlspecialchars($valores['fecha_devolucion']) : date('Y-m-d', strtotime('+15 days')); ?>" required>
            <?php if (isset($errores['fecha_devolucion'])): ?>
                <div class="error_campo"><?php echo htmlspecialchars($errores['fecha_devolucion']); ?></div>
                <?php endif; ?>
        </div>

        <div class="botones">
            <button type="submit">Registrar préstamo</button>
        </div>
    </form>
    <?php else: ?>
        <div class="mensaje error">No hay libros disponibles para préstamo.</div>
    <?php endif; ?>

    <a href="index.php">Volver al inicio</a>
</body>
</html>