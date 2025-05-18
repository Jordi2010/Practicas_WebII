<!-- xss/seguro/comentarios.php -->
<?php
// SOLUCIÓN: Sanitizar la salida
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
    file_put_contents('comentarios.txt', $comentario . PHP_EOL, FILE_APPEND);
}

$comentarios = file_exists('comentarios.txt') ? file('comentarios.txt', FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comentarios - Protegido contra XSS</title>
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
            max-width: 600px;
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
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
            min-height: 100px;
            font-family: inherit;
        }
        
        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.2s;
        }
        
        button:hover {
            background-color: #27ae60;
        }
        
        h3 {
            margin: 25px 0 15px 0;
            color: #333;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .comentario {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 4px;
            border-left: 3px solid #2ecc71;
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
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
        <h1>Comentarios Seguros</h1>
        
        <div class="hint">
            <p>Esta página está protegida contra ataques XSS. Intenta añadir el siguiente comentario: 
            <code>&lt;script&gt;alert('XSS!')&lt;/script&gt;</code> y verás que aparece como texto plano.</p>
        </div>
        
        <form method="POST">
            <div class="form-group">
                <label for="comentario">Deja tu comentario:</label>
                <textarea id="comentario" name="comentario" required></textarea>
            </div>
            
            <button type="submit">Enviar comentario</button>
        </form>
        
        <h3>Comentarios:</h3>
        <?php if (empty($comentarios)): ?>
            <p>No hay comentarios todavía. ¡Sé el primero en comentar!</p>
        <?php else: ?>
            <?php foreach ($comentarios as $c): ?>
                <div class="comentario"><?= htmlspecialchars($c, ENT_QUOTES, 'UTF-8') ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        
        <a href="../../index.php" class="back-link">Volver al inicio</a>
    </div>
</body>
</html>
