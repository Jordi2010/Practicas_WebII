<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // while ($row = $users->fetch(PDO::FETCH_ASSOC)) :
            require_once 'controllers/BankController.php';
            $controller = new BankController();
            $users = $controller->listUsers();

            if ($users):
                foreach ($users as $user):
            ?>
                <tr>
                    <td><?= htmlspecialchars($user['id']) ?></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= number_format($user['balance'], 2) ?></td>
                </tr>
            <?php
            // endwhile;
                endforeach;
            else:
                echo "<tr><td colspan='4'>No hay usuarios registrados.</td></tr>";
            endif;
            ?>
        </tbody>
    </table>

    <hr>

    <!-- Formulario: Agregar usuario -->
    <h2>Agregar usuario</h2>
    <form action="index.php?section=users" method="post">
        <input type="hidden" name="action" value="add_user">
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="balance" placeholder="Balance" step="0.01" min="0">
        <button type="submit">Agregar</button>
    </form>

    <!-- Formulario: Actualizar usuario -->
    <h2>Actualizar usuario</h2>
    <form action="index.php?section=users" method="post">
        <input type="hidden" name="action" value="update_user">
        <input type="number" name="id" placeholder="ID Usuario" required>
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="number" name="balance" placeholder="Balance" step="0.01" min="0">
        <button type="submit">Actualizar</button>
    </form>

    <!-- Formulario: Eliminar usuario -->
    <h2>Eliminar usuario</h2>
    <form action="index.php?section=users" method="post">
        <input type="hidden" name="action" value="delete_user">
        <input type="number" name="id" placeholder="ID usuario" required>
        <button type="submit">Eliminar</button>
    </form>
</body>
</html>
