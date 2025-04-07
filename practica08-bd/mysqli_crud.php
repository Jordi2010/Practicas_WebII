<!-- Práctica 8 (ejercicio 1)
Asignatura: Programación Web II (práctica).
Estudiante: Jordi Haziel Amaya Martínez. -->

<?php
$servidor = "localhost";
$usuario = "root";
$contrasenia = "";
$basedatos = "practica_php";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasenia, $basedatos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: ".$conexion->connect_error);
}

// Ejercicio 1
// PASO 3: implementación del CRUD con MySQLi

echo "<h2>Gestión de productos (MySQLi)</h2>";

// CREAR - Insertar un nuevo producto
function insertarProducto($conexion, $nombre, $precio, $stock) {
    $sql = "INSERT INTO productos (nombre, precio, stock) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdi", $nombre, $precio, $stock);

    if ($stmt->execute()) {
        echo "<p>Producto agregado correctamente.</p>";
    } else {
        echo "<p>Error al agregar producto: ".$stmt->error."</p>";
    }
    $stmt->close();
}

// LEER - Mostrar todos los productos
function mostrarProductos($conexion) {
    $sql = "SELECT id, nombre, precio, stock FROM productos";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0) {
        echo "<h3>Lista de productos:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Precio</th><th>Stock</th></tr>";

        while ($fila = $resultado->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$fila["id"]."</td>";
            echo "<td>".$fila["nombre"]."</td>";
            echo "<td>$".$fila["precio"]."</td>";
            echo "<td>".$fila["stock"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No hay productos registrados.</p>";
    }
}

// ACTUALIZAR - Modificar un producto existente
function actualizarProducto($conexion, $id, $nombre, $precio, $stock) {
    $sql = "UPDATE productos SET nombre=?, precio=?, stock=? WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdii", $nombre, $precio, $stock, $id);

    if ($stmt->execute()) {
        echo "<p>Producto actualizado correctamente.</p>";
    } else {
        echo "<p>Error al actualizar: ".$stmt->error."</p>";
    }
    $stmt->close();
}

// ELIMINAR - Borrar un producto
function eliminarProducto($conexion, $id) {
    $sql = "DELETE FROM productos WHERE id=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<p>Producto eliminado correctamente.</p>";
    } else {
        echo "<p>Error al eliminar: ".$stmt->error."</p>";
    }
    $stmt->close();
}

// EJEMPLO DE USO
// Insertar productos de ejemplo
insertarProducto($conexion, "Laptop HP", 899.99, 10);
insertarProducto($conexion, "Mouse inalámbrico", 24.50, 45);

// Mostrar todos los productos
mostrarProductos($conexion);

// Actualizar un producto (ID 1)
actualizarProducto($conexion, 1, "Laptop HP Pro", 949.99, 8);

// Mostrar productos actualizados
echo "<h3>Después de actualizar:</h3>";
mostrarProductos($conexion);

// Eliminar un producto (ID 2)
eliminarProducto($conexion, 2);

// Mostrar productos después de eliminar
echo "<h3>Después de eliminar:</h3>";
mostrarProductos($conexion);

// Cerrar conexión
$conexion->close();
?>