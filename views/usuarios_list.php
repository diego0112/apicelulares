<?php
// views/usuarios_list.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/UsuarioController.php';
require_once __DIR__ . '/include/header.php';

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->listarUsuarios();

if (isset($_GET['delete'])) {
    $usuarioController->eliminar($_GET['delete']);
    header('Location: ' . BASE_URL . 'views/usuarios_list.php');
    exit();
}
?>

<style>
    :root {
        --primary-color: #3498db;
        --success-color: #3498db;
        --warning-color: #f39c12;
        --danger-color: #e74c3c;
        --light-color: #ecf0f1;
        --dark-color: #2c3e50;
        --border-radius: 8px;
        --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: var(--dark-color);
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-container {
        background-color: white;
        border-radius: var(--border-radius);
        box-shadow: var(--box-shadow);
        padding: 25px;
    }

    .list-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .list-header h2 {
        color: var(--dark-color);
        font-size: 1.8rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 10px 15px;
        border-radius: var(--border-radius);
        text-decoration: none;
        font-weight: 500;
        transition: var(--transition);
        border: none;
        cursor: pointer;
    }

    .btn-success {
        background-color: var(--success-color);
        color: white;
    }

    .btn-success:hover {
        background-color: #3498db;
        transform: translateY(-2px);
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: white;
    }

    .btn-warning:hover {
        background-color: #e67e22;
        transform: translateY(-2px);
    }

    .btn-danger {
        background-color: var(--danger-color);
        color: white;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        transform: translateY(-2px);
    }

    .table-container {
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table thead {
        background-color: var(--primary-color);
        color: white;
    }

    .table th, .table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .table th {
        font-weight: 600;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .table-actions {
        display: flex;
        gap: 10px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .role-badge {
        background-color: #e0e0ff;
        color: var(--primary-color);
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .list-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .table-actions {
            flex-direction: column;
            gap: 5px;
        }

        .btn {
            width: 100%;
        }
    }
</style>

<div class="container fade-in">
    <div class="dashboard-container">
        <div class="list-header">
            <h2>
                <i class="fas fa-users"></i> Lista de Usuarios
            </h2>
            <a href="<?= BASE_URL ?>views/usuario_form.php" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Agregar Usuario
            </a>
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> ID</th>
                        <th><i class="fas fa-user"></i> Usuario</th>
                        <th><i class="fas fa-id-card"></i> Nombre Completo</th>
                        <th><i class="fas fa-user-tag"></i> Rol</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id_usuario'] ?></td>
                            <td><?= $usuario['username'] ?></td>
                            <td><?= $usuario['nombre_completo'] ?></td>
                            <td>
                                <span class="badge role-badge">
                                    <i class="fas fa-shield-alt"></i> <?= ucfirst($usuario['rol']) ?>
                                </span>
                            </td>
                            <td class="table-actions">
                                <a href="<?= BASE_URL ?>views/usuario_form.php?edit=<?= $usuario['id_usuario'] ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="<?= BASE_URL ?>views/usuarios_list.php?delete=<?= $usuario['id_usuario'] ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/include/footer.php'; ?>
