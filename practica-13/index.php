<!-- index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica de Seguridad PHP</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f9fc;
            padding: 30px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        h1 {
            color: #2c3e50;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        
        h2 {
            color: #3498db;
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .exercise {
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .exercise:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }
        
        .links {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }
        
        a {
            display: inline-block;
            padding: 8px 16px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        a:hover {
            background-color: #2980b9;
        }
        
        .vulnerable {
            background-color: #e74c3c;
        }
        
        .vulnerable:hover {
            background-color: #c0392b;
        }
        
        .secure {
            background-color: #2ecc71;
        }
        
        .secure:hover {
            background-color: #27ae60;
        }
        
        .description {
            margin: 15px 0;
            color: #555;
        }
        
        footer {
            text-align: center;
            margin-top: 40px;
            color: #7f8c8d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Ejercicios de Seguridad en PHP</h1>
            <p>Ejemplos de vulnerabilidades comunes y sus soluciones</p>
        </header>
        
        <div class="exercise">
            <h2>1. Inyección SQL</h2>
            <p class="description">
                Esta vulnerabilidad ocurre cuando los datos proporcionados por el usuario se utilizan directamente en consultas SQL.
                Un atacante puede manipular estas consultas para acceder, modificar o eliminar datos sin autorización.
            </p>
            <div class="links">
                <a href="sqli/vulnerable/login.php" class="vulnerable">Ejemplo Vulnerable</a>
                <a href="sqli/seguro/login.php" class="secure">Solución</a>
                <a href="sqli/vulnerable/ejercicio1.php" class="vulnerable">Ejercicio 1 (vulnerable)</a>
                <a href="sqli/seguro/ejercicio1.php" class="secure">Ejercicio 1 (solución)</a>
            </div>
        </div>

        <div class="exercise">
            <h2>2. Cross-Site Scripting (XSS)</h2>
            <p class="description">
                XSS permite a los atacantes inyectar scripts del lado del cliente en páginas web vistas por otros usuarios.
                Esto puede permitir el robo de cookies de sesión o la manipulación del contenido.
            </p>
            <div class="links">
                <a href="xss/vulnerable/comentarios.php" class="vulnerable">Ejemplo Vulnerable</a>
                <a href="xss/seguro/comentarios.php" class="secure">Solución</a>
                <a href="xss/vulnerable/ejercicio2.php" class="vulnerable">Ejercicio 2 (vulnerable)</a>
                <a href="xss/seguro/ejercicio2.php" class="secure">Ejercicio 2 (solución)</a>
            </div>
        </div>

        <div class="exercise">
            <h2>3. Cross-Site Request Forgery (CSRF)</h2>
            <p class="description">
                CSRF engaña a los usuarios para que ejecuten acciones no deseadas en una aplicación web en la que están autenticados.
                Esto puede permitir cambios no autorizados como modificar emails, contraseñas u otros datos sensibles.
            </p>
            <div class="links">
                <a href="csrf/vulnerable/cambiar-email.php" class="vulnerable">Ejemplo Vulnerable</a>
                <a href="csrf/seguro/cambiar-email.php" class="secure">Solución</a>
            </div>
        </div>
        
        <footer>
            <p>Práctica 13 - Seguridad en Aplicaciones Web</p>
        </footer>
    </div>
</body>
</html>
