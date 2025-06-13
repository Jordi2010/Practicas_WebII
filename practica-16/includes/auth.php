<?php
session_start();
require_once __DIR__ . '/../config/database.php';

class Auth {
    
    public static function login($username, $password) {
        try {
            $db = getDB();
            $stmt = $db->prepare("SELECT id, username, email, password, nombre FROM usuarios WHERE username = ? AND activo = 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['logged_in'] = true;
                return true;
            }
            return false;
        } catch (Exception $e) {
            error_log("Error en login: " . $e->getMessage());
            return false;
        }
    }
    
    public static function logout() {
        session_destroy();
        header("Location: ../login.php");
        exit();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }
    
    public static function requireLogin() {
        if (!self::isLoggedIn()) {
            header("Location: ../login.php");
            exit();
        }
    }
    
    public static function getCurrentUser() {
        if (self::isLoggedIn()) {
            return [
                'id' => $_SESSION['user_id'],
                'username' => $_SESSION['username'],
                'nombre' => $_SESSION['nombre'],
                'email' => $_SESSION['email']
            ];
        }
        return null;
    }
}

// Funciones helper
function isLoggedIn() {
    return Auth::isLoggedIn();
}

function requireLogin() {
    Auth::requireLogin();
}

function getCurrentUser() {
    return Auth::getCurrentUser();
}
?> 