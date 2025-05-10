<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de biblioteca</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        h1, h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .contenedor {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }
        .box {
            flex: 1;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 5px;
        }
        .mensaje {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .exito {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Sistema de gestión de biblioteca</h1>
    <?php
    if (isset($_GET['mensaje'])) {
        echo '<div class="mensaje exito">' . htmlspecialchars($_GET['mensaje']) . '</div>';
    }
    ?>

    <div>
        <div>
            <h2>Gesstión de libros</h2>
            <p><a href="libro_crear.php">Registrar nuevo libro</a></p>
        </div>

        <div>
            <h2>Gestión de préstamos</h2>
            <p><a href="prestamo_crear.php">Registrar nuevo préstamo</a></p>
        </div>
    </div>

    <h2>Catálogo de libros</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Autor</th>
                <th>ISBN</th>
                <th>Ejemplares</th>
                <th>Disponibles</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $pdo->query("
                SELECT l.id, l.titulo, l.autor, l.isbn, l.ejemplares,
                (l.ejemplares - COUNT(CASE WHEN p.estado = 'prestado' THEN 1 END)) as disponibles
                FROM libros l
                LEFT JOIN prestamos p ON l.id = p.libro_id
                GROUP BY l.id
                ORDER BY l.titulo
                ");
                if ($stmt->rowCount() > 0) {
                    while ($libro = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>".$libro['id']."</td>";
                        echo "<td>".htmlspecialchars($libro['titulo'])."</td>";
                        echo "<td>".htmlspecialchars($libro['autor'])."</td>";
                        echo "<td>".htmlspecialchars($libro['isbn'])."</td>";
                        echo "<td>".$libro['ejemplares']."</td>";
                        echo "<td>".$libro['disponibles']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td coldspan='6'>No hay libros registrados</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='6'>Error al cargar los datos: ".$e->getMessage()."</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Préstamos activos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Libro</th>
                <th>Lector</th>
                <th>Email</th>
                <th>Fecha préstamo</th>
                <th>Fecha devolución</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $pdo->query("
                SELECT p.*, l.titulo
                FROM prestamos p
                JOIN libros l ON p.libro_id = l.id
                WHERE p.estado = 'prestado'
                ORDER BY p.fecha_devolucion ASC
                ");
                if ($stmt->rowCount() > 0) {
                    while ($prestamo = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $hoy = date('Y-m-d');
                        $clase = '';
                        if ($prestamo['fecha_devolucion'] < $hoy) {
                            $clase = 'style="background-color: #fff3cd;"';
                        }
                        echo "<tr $clase>";
                        echo "<td>".$prestamo['id']."</td>";
                        echo "<td>".htmlspecialchars($prestamo['titulo'])."</td>";
                        echo "<td>".htmlspecialchars($prestamo['nombre_lector'])."</td>";
                        echo "<td>".htmlspecialchars($prestamo['email'])."</td>";
                        echo "<td>".$prestamo['fecha_prestamo']."</td>";
                        echo "<td>".$prestamo['fecha_devolucion']."</td>";
                        echo "<td>".$prestamo['estado']."</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No hay préstamos activos</td></tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='7'>Error al cargar los datos: ".$e->getMessage()."</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>