<?php
// index.php - Página principal del sistema de autenticación segura
session_start();

// Verificar si hay una sesión activa
$is_logged_in = !empty($_SESSION['user_id']);
$current_user = null;

if ($is_logged_in) {
    require_once 'conexion.php';
    $stmt = $pdo->prepare("SELECT usuario, email, fecha_registro FROM usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $current_user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Autenticación Segura</title>
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .header h1 {
            color: #4a5568;
            text-align: center;
            margin-bottom: 10px;
        }
        
        .header p {
            text-align: center;
            color: #718096;
        }
        
        .nav-bar {
            background: rgba(255, 255, 255, 0.9);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        .nav-link {
            background: #4299e1;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
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
        
        .main-content {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .user-info {
            background: #e6fffa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #38b2ac;
            margin-bottom: 30px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: #f7fafc;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        
        .feature-card h3 {
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .feature-card p {
            color: #4a5568;
            font-size: 14px;
        }
        
        .welcome-section {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .welcome-section h2 {
            color: #2d3748;
            margin-bottom: 15px;
        }
        
        .guest-actions {
            text-align: center;
            margin-top: 30px;
        }
        
        .btn-primary {
            background: #4299e1;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-secondary {
            background: #48bb78;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 6px;
            margin: 0 10px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: #3182ce;
            transform: translateY(-2px);
        }
        
        .btn-secondary:hover {
            background: #38a169;
            transform: translateY(-2px);
        }
        
        .security-demo {
            background: #fff5f5;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #f56565;
            margin-top: 20px;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        
        .stat-card {
            background: #edf2f7;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #4299e1;
        }
        
        .stat-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔐 Sistema de Autenticación Segura</h1>
            <p>Práctica 15 - Implementación de seguridad básica con PHP</p>
        </div>
        
        <?php if ($is_logged_in): ?>
            <!-- Usuario logueado -->
            <div class="nav-bar">
                <a href="bienvenida.php" class="nav-link">Mi Perfil</a>
                <a href="logout.php" class="nav-link logout">Cerrar Sesión</a>
            </div>
            
            <div class="main-content">
                <div class="user-info">
                    <h3>👋 ¡Bienvenido, <?= htmlspecialchars($current_user['usuario']) ?>!</h3>
                    <p><strong>Email:</strong> <?= htmlspecialchars($current_user['email']) ?></p>
                    <p><strong>Miembro desde:</strong> <?= date('d/m/Y', strtotime($current_user['fecha_registro'])) ?></p>
                </div>
                
                <div class="welcome-section">
                    <h2>Panel de Control</h2>
                    <p>Has iniciado sesión correctamente. Puedes acceder a todas las funcionalidades del sistema.</p>
                </div>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>🛡️ Sesión Segura</h3>
                        <p>Tu sesión está protegida con regeneración de ID y tokens CSRF para prevenir ataques de fijación de sesión.</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>🔒 Contraseñas Encriptadas</h3>
                        <p>Las contraseñas se almacenan usando hash seguro con PASSWORD_DEFAULT de PHP (bcrypt).</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>🚫 Protección XSS</h3>
                        <p>Toda la salida está sanitizada con htmlspecialchars() para prevenir ataques de Cross-Site Scripting.</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>💉 Prevención SQL Injection</h3>
                        <p>Todas las consultas usan prepared statements para evitar inyección SQL.</p>
                    </div>
                </div>
                
                <?php
                // Demostrar estadísticas del sistema
                try {
                    $total_users = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
                    $recent_users = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE fecha_registro >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetchColumn();
                } catch (Exception $e) {
                    $total_users = "N/A";
                    $recent_users = "N/A";
                }
                ?>
                
                <div class="stats">
                    <div class="stat-card">
                        <div class="stat-number"><?= $total_users ?></div>
                        <div class="stat-label">Usuarios Totales</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><?= $recent_users ?></div>
                        <div class="stat-label">Nuevos (7 días)</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">Active</div>
                        <div class="stat-label">Estado Sesión</div>
                    </div>
                </div>
            </div>
            
        <?php else: ?>
            <!-- Usuario no logueado -->
            <div class="nav-bar">
                <a href="login.php" class="nav-link">Iniciar Sesión</a>
                <a href="crear_usuario.php" class="nav-link">Registrarse</a>
            </div>
            
            <div class="main-content">
                <div class="welcome-section">
                    <h2>🔐 Bienvenido al Sistema de Autenticación</h2>
                    <p>Este sistema implementa las mejores prácticas de seguridad en PHP para autenticación de usuarios.</p>
                </div>
                
                <div class="guest-actions">
                    <a href="login.php" class="btn-primary">Iniciar Sesión</a>
                    <a href="crear_usuario.php" class="btn-secondary">Crear Cuenta Nueva</a>
                </div>
                
                <div class="features-grid">
                    <div class="feature-card">
                        <h3>🔒 Autenticación Segura</h3>
                        <p>Sistema de login con validación robusta y protección contra ataques comunes.</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>🛡️ Protección CSRF</h3>
                        <p>Todos los formularios incluyen tokens CSRF para prevenir ataques de falsificación de peticiones.</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>📝 Registro de Usuarios</h3>
                        <p>Creación de cuentas con validación de email y confirmación de contraseña.</p>
                    </div>
                    
                    <div class="feature-card">
                        <h3>🚪 Gestión de Sesiones</h3>
                        <p>Manejo seguro de sesiones con logout completo y limpieza de cookies.</p>
                    </div>
                </div>
                
                <div class="security-demo">
                    <h3>🔍 Características de Seguridad Implementadas:</h3>
                    <ul style="margin-top: 10px; padding-left: 20px;">
                        <li>Prepared Statements para prevenir SQL Injection</li>
                        <li>Tokens CSRF en todos los formularios</li>
                        <li>Encriptación de contraseñas con password_hash()</li>
                        <li>Sanitización de entrada con filter_input()</li>
                        <li>Escape de salida con htmlspecialchars()</li>
                        <li>Regeneración de ID de sesión</li>
                        <li>Validación de entrada de usuarios</li>
                        <li>Headers de seguridad apropiados</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 30px; color: rgba(255,255,255,0.8);">
            <p>&copy; 2024 Sistema de Autenticación Segura - Práctica de Seguridad Web</p>
        </div>
    </div>
</body>
</html> 