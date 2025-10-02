<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}
// Manejar eliminación
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    require_once __DIR__ . '/../controllers/ClientApiController.php';
    $clientApiController = new ClientApiController();
    if ($clientApiController->borrarCliente($_GET['delete'])) {
        $mensaje = "✅ Cliente eliminado exitosamente";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "❌ Error al eliminar el cliente";
        $tipo_mensaje = "error";
    }
}
// Obtener lista de clientes
require_once __DIR__ . '/../controllers/ClientApiController.php';
$clientApiController = new ClientApiController();
$clientes = $clientApiController->listarClientes();
require_once __DIR__ . '/include/header.php';
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
    .estado-activo {
        background-color: #d4edda;
        color: #155724;
    }
    .estado-inactivo {
        background-color: #f8d7da;
        color: #721c24;
    }
    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #666;
    }
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
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
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                <i class="fas <?= $tipo_mensaje == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <div class="list-header">
            <h2>
                <i class="fas fa-users"></i> Gestión de Clientes
            </h2>
            <a href="<?php echo BASE_URL; ?>views/cliente_form.php" class="btn btn-success">
                <i class="fas fa-user-plus"></i> Agregar Cliente
            </a>
        </div>
        <?php if (empty($clientes)): ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fas fa-users"></i></div>
            <h3>No hay clientes registrados</h3>
            <p>Comienza agregando tu primer cliente al sistema.</p>
            <a href="<?php echo BASE_URL; ?>views/cliente_form.php" class="btn btn-success" style="margin-top: 1rem;">
                <i class="fas fa-user-plus"></i> Agregar Primer Cliente
            </a>
        </div>
        <?php else: ?>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag"></i> #</th>
                        <th><i class="fas fa-id-card"></i> RUC</th>
                        <th><i class="fas fa-building"></i> Razón Social</th>
                        <th><i class="fas fa-phone"></i> Teléfono</th>
                        <th><i class="fas fa-envelope"></i> Correo</th>
                        <th><i class="fas fa-toggle-on"></i> Estado</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($clientes as $cliente): ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($cliente['ruc']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($cliente['correo']); ?></td>
                            <td>
                                <span class="badge <?php echo $cliente['estado'] ? 'estado-activo' : 'estado-inactivo'; ?>">
                                    <i class="fas fa-circle"></i> <?php echo $cliente['estado'] ? 'Activo' : 'Inactivo'; ?>
                                </span>
                            </td>
                            <td class="table-actions">
                                <a href="<?php echo BASE_URL; ?>views/cliente_form.php?edit=<?php echo $cliente['id']; ?>" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="#" class="btn btn-danger" onclick="confirmarEliminacion(<?php echo $cliente['id']; ?>, '<?php echo addslashes($cliente['razon_social']); ?>')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
<script>
    function confirmarEliminacion(id, nombre) {
        if (confirm(`¿Estás seguro de que deseas eliminar al cliente "${nombre}"?`)) {
            window.location.href = `<?php echo BASE_URL; ?>views/clientes_list.php?delete=${id}`;
        }
    }
</script>
<?php require_once __DIR__ . '/include/footer.php'; ?>
