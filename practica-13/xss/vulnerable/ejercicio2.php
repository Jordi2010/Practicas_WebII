<?php
// Ejercicio 2: Cross-Site Scripting (XSS)
// EJERCICIO: corregir esta vulnerabilidad
session_start();
$usuario = [
    'nombre' => '<script>alert("Hacked!")</script>',
    'email' => 'usuario@example.com'
];
?>

<h2>Perfil de usuario</h2>
<!-- ¡Vulnerabilidad XSS! -->
<p>Nombre: <?= $usuario['nombre'] ?></p>
<p>Email: <?= $usuario['email'] ?></p>
<br>
<a href="../../index.php" class="back-link">Volver al inicio</a>
<!--
Instrucciones:
1. Identificar la vulnerabilidad XSS
2. Sanitizar la salida del nombre
3. Probar cargando la página
4. Verificar que no se ejecute el script
-->