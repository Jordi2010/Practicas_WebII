<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Transacciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        td:nth-child(3) { /* Monto column */
            text-align: right;
            font-family: monospace;
        }
    </style>
</head>
<body>
    <h1>Lista de Transacciones</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Monto</th>
                <th>Tipo</th>
                <th>Descripción</th>
            </tr>   
        </thead>
        <tbody>
            <?php
            //while ($row = $transactions->fetch(PDO::FETCH_ASSOC)) :
            require_once 'controllers/BankController.php';
            $controller = new BankController();
            $transactions = $controller->listTransactions();

            if ($transactions):
                foreach ($transactions as $tx):
            ?>
                <tr>
                    <td><?= htmlspecialchars($tx['id']) ?></td>
                    <td><?= htmlspecialchars($tx['user_id']) ?></td>
                    <td><?= number_format($tx['amount'], 2) ?></td>
                    <td><?= htmlspecialchars($tx['type']) ?></td>
                    <td><?= htmlspecialchars($tx['description']) ?></td>
                </tr>
            <?php
            //endwhile;
                endforeach;
            else:
                echo "<tr><td colspan='5'>No hay transacciones registradas.</td></tr>";
            endif;
            ?>
        </tbody>
    </table>

    <hr>

    <!-- Formulario: Agregar transacción -->
    <h2>Agregar transacción</h2>
    <form method="post" action="index.php?section=transactions">
        <input type="hidden" name="action" value="add_transaction">
        <input type="number" name="user_id" placeholder="ID Usuario" required>
        <input type="number" step="0.01" min="0" name="amount" placeholder="Monto" required>
        <select name="type" required>
            <option value="deposit">Depósito</option>
            <option value="withdrawal">Retiro</option>
            <option value="transfer">Transferencia</option>
        </select>
        <input type="text" name="description" placeholder="Descripción">
        <button type="submit">Agregar</button>
    </form>

    <!-- Formulario: Actualizar transacción -->
    <h2>Actualizar Transacción</h2>
    <form method="post" action="index.php?section=transactions">
        <input type="hidden" name="action" value="update_transaction">
        <input type="number" name="id" placeholder="ID Transacción" required>
        <input type="number" name="user_id" placeholder="ID Usuario" required>
        <input type="number" step="0.01" min="0" name="amount" placeholder="Monto" required>
        <select name="type" required>
            <option value="deposit">Depósito</option>
            <option value="withdrawal">Retiro</option>
            <option value="transfer">Transferencia</option>
        </select>
        <input type="text" name="description" placeholder="Descripción">
        <button type="submit">Actualizar</button>
    </form>
    
    <!-- Formulario: Eliminar usuario -->
    <h2>Eliminar Transacción</h2>
    <form method="POST" action="index.php?section=transactions">
        <input type="hidden" name="action" value="delete_transaction">
        <input type="number" name="id" placeholder="ID Transacción" required>
        <button type="submit">Eliminar</button>
    </form>
</body>
</html>
