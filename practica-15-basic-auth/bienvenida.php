<?php
// bienvenida.php
session_start();

// Verificar autenticación
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexion.php';

// Obtener datos del usuario actual
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Sistema Seguro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .nav-bar {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .nav-links {
            display: flex;
            gap: 15px;
        }
        
        .nav-link {
            background: #4299e1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            background: #3182ce;
            transform: translateY(-2px);
        }
        
        .nav-link.logout {
            background: #e53e3e;
        }
        
        .nav-link.logout:hover {
            background: #c53030;
        }
        
        .profile-container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .profile-header h1 {
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .user-info {
            background: #f7fafc;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #4299e1;
            margin-bottom: 30px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #4a5568;
        }
        
        .info-value {
            color: #2d3748;
        }
        
        .security-demo {
            background: #fff5f5;
            padding: 25px;
            border-radius: 8px;
            border-left: 4px solid #f56565;
        }
        
        .demo-section {
            margin-bottom: 20px;
        }
        
        .demo-section:last-child {
            margin-bottom: 0;
        }
        
        .demo-title {
            font-weight: 600;
            color: #742a2a;
            margin-bottom: 10px;
        }
        
        .safe-output {
            background: #c6f6d5;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            border-left: 3px solid #38a169;
        }
        
        .unsafe-output {
            background: #fed7d7;
            padding: 10px;
            border-radius: 5px;
            margin: 5px 0;
            border-left: 3px solid #e53e3e;
        }
        
        .warning {
            color: #c53030;
            font-size: 12px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav-bar">
            <div class="nav-links">
                <a href="index.php" class="nav-link">← Inicio</a>
            </div>
            <div class="nav-links">
                <a href="logout.php" class="nav-link logout">Cerrar Sesión</a>
            </div>
        </div>
        
        <div class="profile-container">
            <div class="profile-header">
                <h1>👤 Mi Perfil</h1>
                <p>Información de tu cuenta y demostración de seguridad</p>
            </div>
            
            <div class="user-info">
                <div class="info-item">
                    <span class="info-label">👤 Usuario:</span>
                    <span class="info-value"><?= htmlspecialchars($user['usuario']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">📧 Email:</span>
                    <span class="info-value"><?= htmlspecialchars($user['email']) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">📅 Fecha de registro:</span>
                    <span class="info-value"><?= date('d/m/Y H:i', strtotime($user['fecha_registro'])) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">🆔 ID de usuario:</span>
                    <span class="info-value"><?= htmlspecialchars($user['id']) ?></span>
                </div>
            </div>
            
            <div class="security-demo">
                <h3 style="color: #742a2a; margin-bottom: 20px;">🔍 Demostración de Protección contra XSS</h3>
                
                <div class="demo-section">
                    <div class="demo-title">Entrada maliciosa simulada:</div>
                    <?php
                    // Simular entrada de usuario maliciosa
                    $userInput = "<script>alert('¡Sistema comprometido!');</script><img src=x onerror=alert('XSS')>";
                    ?>
                    <code style="background: #edf2f7; padding: 5px; border-radius: 3px; display: block; margin: 5px 0;">
                        <?= htmlspecialchars($userInput) ?>
                    </code>
                </div>
                
                <div class="demo-section">
                    <div class="demo-title">✅ Salida SEGURA (con htmlspecialchars):</div>
                    <div class="safe-output">
                        <?= htmlspecialchars($userInput) ?>
                    </div>
                    <small style="color: #22543d;">Los caracteres especiales fueron escapados correctamente</small>
                </div>
                
                <div class="demo-section">
                    <div class="demo-title">❌ Salida INSEGURA (SIN sanitizar):</div>
                    <div class="unsafe-output">
                        <?= $userInput ?>
                        <div class="warning">⚠️ NUNCA hagas esto en producción - Esto ejecutaría JavaScript malicioso</div>
                    </div>
                </div>
                
                <div style="margin-top: 20px; padding: 15px; background: #edf2f7; border-radius: 6px;">
                    <strong>🛡️ Medidas de seguridad implementadas en esta aplicación:</strong>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <li>Prepared statements para prevenir SQL Injection</li>
                        <li>Tokens CSRF en todos los formularios</li>
                        <li>Sanitización de salida con htmlspecialchars()</li>
                        <li>Hashing seguro de contraseñas</li>
                        <li>Validación y filtrado de entrada</li>
                        <li>Regeneración de ID de sesión</li>
                        <li>Verificación de autenticación en páginas protegidas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
