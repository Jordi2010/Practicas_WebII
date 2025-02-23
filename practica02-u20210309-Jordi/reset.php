<!-- Práctica 2 (ejercicio 2)
Asignatura: Programación Web II.
Estudiante: Jordi Haziel Amaya Martínez. -->

<!-- Ejercicio 2. Sistema de autenticación.
Crea un sistema de login que verifique:
- Si el usuario está bloqueado -> "Cuenta bloqueada".
- Si el usuario existe y la contraseña coincide -> "Acceso permitido".
- Si el usuario existe, pero la contraseña no coincide:
    * Si los intentos son menores a 3 -> "Contraseña incorrecta, intentos restantes: X".
    * Si los intentos son 3 o más -> "Cuenta bloqueada por seguridad".
- Si el usuario no existe -> "Usuario no encontrado". -->

<?php
// Reinicia el ejercicio 2, para poderse ejecutar de nuevo al regresar al index
session_start();
session_destroy();
header("Location: index.php");
exit();
?>