<!-- csrf/vulnerable/cambiar_email.php -->
<?php
// VULNERABLE: Sin protección CSRF
session_start();
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = 'test@example.com';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['usuario'] = $_POST['nuevo_email'];
    $mensaje = "<div class='alert success'>Email actualizado a: " . htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') . "</div>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Email - Vulnerable a CSRF</title>
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
            color: #e74c3c;
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .hint {
            background-color: #ffe9e7;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 0.9em;
        }
        
        .current-email {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #eee;
        }
        
        .current-email strong {
            color: #e74c3c;
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
        
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        
        button {
            background-color: #e74c3c;
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
            background-color: #c0392b;
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
        <h1>Cambiar Email Vulnerable</h1>
        
        <div class="hint">
            <p>Esta página es vulnerable a ataques CSRF ya que no implementa ningún token de protección.</p>
            <p>Un atacante podría crear un formulario malicioso en otro sitio que envíe una petición aquí.</p>
        </div>
        
        <div class="current-email">
            Email actual: <strong><?= htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') ?></strong>
        </div>
        
        <?php if (isset($mensaje)) echo $mensaje; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="nuevo_email">Nuevo email:</label>
                <input type="email" id="nuevo_email" name="nuevo_email" required>
            </div>
            
            <button type="submit">Actualizar email</button>
        </form>
        
        <a href="../../index.php" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>
