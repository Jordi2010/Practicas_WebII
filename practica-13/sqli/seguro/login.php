<!-- sqli/seguro/login.php -->
<?php
// SOLUCIÓN: Usar consultas preparadas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new mysqli('localhost', 'root', '', 'test');
    
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    
    // Consulta segura con prepared statements
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $stmt->bind_param("ss", $usuario, $password);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $mensaje = "<div class='alert success'>¡Acceso concedido!</div>";
    } else {
        $mensaje = "<div class='alert error'>Credenciales inválidas</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Protegido contra SQL Injection</title>
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
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #2ecc71;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .hint {
            background-color: #e7ffe9;
            border-left: 4px solid #2ecc71;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        
        form {
            margin-top: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        
        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.2s;
        }
        
        button:hover {
            background-color: #27ae60;
        }
        
        .alert {
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
            font-weight: bold;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        code {
            background-color: #f8f9fa;
            padding: 3px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login Seguro</h1>
        
        <div class="hint">
            <p>Esta página está protegida contra ataques de SQL Injection usando consultas preparadas.</p>
            <p>Intenta usar <code>admin' OR '1'='1code> como usuario y verás que no funciona.</p>
        </div>
        
        <?php if (isset($mensaje)) echo $mensaje; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="usuario">Usuario:</label>
                <input type="text" id="usuario" name="usuario" required>
            </div>
            
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit">Iniciar sesión</button>
        </form>
        
        <a href="../../index.php" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>
