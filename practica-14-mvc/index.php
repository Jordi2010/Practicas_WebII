<?php
require_once 'controllers/BankController.php';

$controller = new BankController();
//--------------------------------------------------------------------------------
// Manejo de solicitudes POST para el CRUD de usuarios y transacciones
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    switch ($action) {
        // USUARIOS
        case 'add_user':
            $controller->addUser($_POST['username'], $_POST['email'], $_POST['balance']);
            break;
        case 'update_user':
            $controller->updateUser($_POST['id'], $_POST['username'], $_POST['email'], $_POST['balance']);
            break;
        case 'delete_user':
            $controller->deleteUser($_POST['id']);
            break;
        // TRANSACCIONES
        case 'add_transaction':
            $controller->addTransaction($_POST['user_id'], $_POST['amount'], $_POST['type'], $_POST['description']);
            break;
        case 'update_transaction':
            $controller->updateTransaction($_POST['id'], $_POST['user_id'], $_POST['amount'], $_POST['type'], $_POST['description']);
            break;
        case 'delete_transaction':
            $controller->deleteTransaction($_POST['id']);
            break;
    }

    // Redireccionar a la misma sección
    $section = $_GET['section'] ?? 'transactions';
    header("Location: index.php?section=$section");
    exit;
}

// Mostrar la sección correspondiente
$section = $_GET['section'] ?? 'transactions';
//--------------------------------------------------------------------------------

// Ejemplo: agregar usuario (descomenta para probar)
// $controller->addUser('juan123', 'juan@example.com', 1000);

// Ejemplo: agregar transacción (descomenta para probar)
// $controller->addTransaction(1, 200, 'deposit', 'Depósito inicial');

$users = $controller->listUsers();
$transactions = $controller->listTransactions();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Bancario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 30px;
        }

        .section {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Sistema bancario</h1>
    <nav>
        <a href="index.php?section=transactions">Transacciones</a> |
        <a href="index.php?section=users">Usuarios</a> |
    </nav>
    <hr>

    <?php
        if ($section === 'users') {
            include 'views/users.php';
        } else {
            include 'views/transactions.php';
        }
    ?>

    
</body>
</html>
