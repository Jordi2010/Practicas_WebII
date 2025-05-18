<?php
// Ejercicio 2: Cross-Site Scripting (XSS)
// SOLUCIÓN
$comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
session_start();
$usuario = [
    'nombre' => '<script>alert("Hacked!")</script>',
    'email' => 'usuario@example.com'
];
?>

<h2>Perfil de usuario</h2>
<!-- ¡Vulnerabilidad XSS! -> Solucionada al sanitizar las salidas -->
<p>Nombre: <?= htmlspecialchars($usuario['nombre'], ENT_QUOTES, 'UTF-8') ?></p>
<p>Email: <?= htmlspecialchars($usuario['email'], ENT_QUOTES, 'UTF-8') ?></p>
<br>
<a href="../../index.php" class="back-link">Volver al inicio</a>