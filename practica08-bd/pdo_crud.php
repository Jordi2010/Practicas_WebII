<!-- Práctica 8 (ejercicio 2)
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<?php
$servidor = "mysql:host=localhost;dbname=practica_php";     // Tipo de DB + servidor + nombre BD
$usuario = "root";              // Usuario de la base de datos
$contrasenia = "";              // Contraseña (vacía en XAMPP)

try {
    // Crear conexión PDO con manejo de errores en modo excepción
    $pdo = new PDO($servidor, $usuario, $contrasenia);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    
    // Ejercicio 2
    // PASO 4: implementación del CRUD con PDO

    echo "<h2>Gestión de inventario (PDO)</h2>";

    // CREAR - Función para insertar un nuevo producto
    function insertarProducto($pdo, $nombre, $precio, $stock) {
        try {
            $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (:nombre, :precio, :stock)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":precio", $precio, PDO::PARAM_STR);
            $stmt->bindParam(":stock", $stock, PDO::PARAM_INT);
            $stmt->execute();

            echo "<p>Producto '{$nombre}' agregado con ID: ".$pdo->lastInsertId()."</p>";
        } catch (PDOException $e) {
            echo "<p>Error al insertar: ".$e->getMessage()."</p>";
        }
    }

    // LEER - Buscar productos por criterios
    function buscarProductos($pdo, $criterio = null, $valor = null) {
        try {
            if ($criterio && $valor) {
                // Búsqueda con filtro
                $sql = "SELECT * FROM productos WHERE {$criterio} LIKE :valor";
                $stmt = $pdo->prepare($sql);
                $valorBusqueda = "%{$valor}%";
                $stmt->bindParam(":valor", $valorBusqueda);
            } else {
                // Buscar todos
                $sql = "SELECT * FROM productos ORDER BY id";
                $stmt = $pdo->prepare($sql);
            }

            $stmt->execute();
            $productos = $stmt->fetchAll();

            if (count($productos) > 0) {
                echo "<h3>Resultados (".count($productos)." productos):</h3>";
                echo "<table border='1'>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>";

                foreach ($productos as $producto) {
                    echo "<tr>";
                    echo "<td>".$producto["id"]."</td>";
                    echo "<td>".$producto["nombre"]."</td>";
                    echo "<td>$".$producto["precio"]."</td>";
                    echo "<td>".$producto["stock"]."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No se encontraron productos.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al buscar: ".$e->getMessage()."</p>";
        }
    }

    // ACTUALIZAR - Actualizar stock con transacción
    function actualizarStock($pdo, $id, $nuevoStock) {
        try {
            // Iniciar transacción
            $pdo->beginTransaction();

            // Obtener stock actual
            $sql = "SELECT stock FROM productos WHERE id = :id FOR UPDATE";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            $productoActual = $stmt->fetch();

            if(!$productoActual) {
                throw new Exception("Producto no encontrado");
            }

            // Actualizar stock
            $sql = "UPDATE productos SET stock = :stock WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":stock", $nuevoStock, PDO::PARAM_INT);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmar cambios
            $pdo->commit();
            echo "<p>Stock actualizado: de {$productoActual['stock']} a {$nuevoStock}.</p>";

        } catch (Exception $e) {
            // Revertir cambios si hay error
            $pdo->rollBack();
            echo "<p>Error en la transacción: ".$e->getMessage()."</p>";
        }
    }

    // ELIMINAR - Eliminar productos
    function eliminarProducto($pdo, $id) {
        try {
            $sql = "DELETE FROM producto WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "<p>Producto eliminado correctamente.</p>";
            } else {
                echo "<p>No se encontró el producto para eliminar.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Error al eliminar: ".$e->getMessage()."</p>";
        }
    }

    // EJEMPLO DE USO
    // Insertar nuevos productos
    insertarProducto($pdo, "Teclado mecánico", 79.99, 15);
    insertarProducto($pdo, "Monitor 24 pulgadas", 199.50, 7);

    // Mostrar todos los productos
    echo "<h3>Todos los productos:</h3>";
    buscarProductos($pdo);

    // Buscar productos por nombre
    echo "<h3>Búsqueda por nombre:</h3>";
    buscarProductos($pdo, "nombre", "Monitor");

    // Actualizar stock con transacción
    actualizarStock($pdo, 3, 25);   // Actualiza stock del producto ID 3

    // Eliminar un producto
    eliminarProducto($pdo, 4);      // Elimina el producto ID 4

    // Mostrar productos finales
    echo "<h3>Lista final:</h3>";
    buscarProductos($pdo);

} catch (PDOException $e) {
    die("<p>Error de conexión: ".$e->getMessage()."</p>");
} finally {
    // Cerrar conexión
    $pdo = null;
}
?>