<!-- csrf/seguro/cambiar_email.php -->
<?php
// SOLUCIÓN: Token CSRF
session_start();
if (!isset($_SESSION['usuario'])) {
    $_SESSION['usuario'] = 'test@example.com';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $mensaje = "<div class='alert error'>Token CSRF inválido!</div>";
    } else {
        $_SESSION['usuario'] = $_POST['nuevo_email'];
        $mensaje = "<div class='alert success'>Email actualizado a: " . htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8') . "</div>";
    }
}

$csrf_token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrf_token;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Email - Protegido contra CSRF</title>
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
        
        .current-email {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #eee;
        }
        
        .current-email strong {
            color: #2ecc71;
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
        
        .token-info {
            margin-top: 25px;
            padding: 15px;
            background-color: #e8f4fd;
            border-left: 4px solid #3498db;
            border-radius: 4px;
            font-size: 0.9em;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Cambiar Email Seguro</h1>
        
        <div class="hint">
            <p>Esta página está protegida contra ataques CSRF usando un token único para cada sesión.</p>
            <p>Un atacante no podría crear un formulario que envíe una petición válida.</p>
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
            
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <button type="submit">Actualizar email</button>
        </form>
        
        <div class="token-info">
            <p>Token CSRF generado: <br><code><?= substr($csrf_token, 0, 16) ?>...</code> (truncado por razones de espacio)</p>
        </div>
        
        <a href="../../index.php" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>
