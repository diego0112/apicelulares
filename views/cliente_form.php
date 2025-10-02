<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}
require_once __DIR__ . '/../controllers/ClientApiController.php';
$clientApiController = new ClientApiController();
// Determinar si es edición o creación
$isEditing = isset($_GET['edit']) && is_numeric($_GET['edit']);
$cliente = null;
$pageTitle = $isEditing ? 'Editar Cliente' : 'Agregar Nuevo Cliente';
if ($isEditing) {
    $cliente = $clientApiController->obtenerCliente($_GET['edit']);
    if (!$cliente) {
        header('Location: ' . BASE_URL . 'views/clientes_list.php');
        exit();
    }
}
// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ruc = trim($_POST['ruc']);
    $razon_social = trim($_POST['razon_social']);
    $telefono = trim($_POST['telefono']);
    $correo = trim($_POST['correo']);
    $estado = $isEditing ? (isset($_POST['estado']) ? 1 : 0) : 1;
    // Validaciones
    $errores = [];
    if (empty($ruc)) $errores[] = "El campo RUC es obligatorio";
    if (empty($razon_social)) $errores[] = "El campo Razón Social es obligatorio";
    if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) $errores[] = "El formato del correo electrónico no es válido";
    if (empty($errores)) {
        if ($isEditing) {
            $resultado = $clientApiController->editarCliente($_GET['edit'], $ruc, $razon_social, $telefono, $correo, $estado);
            $mensaje = $resultado ? "✅ Cliente actualizado exitosamente" : "❌ Error al actualizar el cliente";
            $tipo_mensaje = $resultado ? "success" : "error";
            $cliente = $clientApiController->obtenerCliente($_GET['edit']);
        } else {
            $resultado = $clientApiController->crearCliente($ruc, $razon_social, $telefono, $correo);
            if ($resultado) {
                header('Location: ' . BASE_URL . 'views/clientes_list.php?created=1');
                exit();
            } else {
                $mensaje = "❌ Error al crear el cliente";
                $tipo_mensaje = "error";
            }
        }
    }
}
require_once __DIR__ . '/include/header.php';
?>
<style>
    :root {
        --primary-color: #3498db;
        --success-color: #2ecc71;
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
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .form-header h2 {
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
    .btn-secondary {
        background-color: #95a5a6;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #7f8c8d;
        transform: translateY(-2px);
    }
    .btn-primary {
        background-color: var(--success-color);
        color: white;
    }
    .btn-primary:hover {
        background-color: #27ae60;
        transform: translateY(-2px);
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: var(--border-radius);
        font-weight: 500;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 15px;
    }
    .form-group {
        flex: 1 1 calc(50% - 20px);
        min-width: 250px;
    }
    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
        color: var(--dark-color);
    }
    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 1rem;
    }
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }
    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
        .form-actions {
            flex-direction: column;
            gap: 10px;
        }
        .btn {
            width: 100%;
        }
    }
</style>
<div class="container fade-in">
    <div class="dashboard-container">
        <div class="form-header">
            <h2>
                <i class="fas fa-user"></i> <?php echo $pageTitle; ?>
            </h2>
            <a href="<?php echo BASE_URL; ?>views/clientes_list.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-<?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errores)): ?>
            <div class="alert alert-error">
                <strong>⚠ Se encontraron errores:</strong>
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group">
                    <label for="ruc"><i class="fas fa-id-card"></i> RUC *</label>
                    <input type="text" id="ruc" name="ruc" value="<?php echo htmlspecialchars($cliente['ruc'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="razon_social"><i class="fas fa-building"></i> Razón Social *</label>
                    <input type="text" id="razon_social" name="razon_social" value="<?php echo htmlspecialchars($cliente['razon_social'] ?? ''); ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="telefono"><i class="fas fa-phone"></i> Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($cliente['telefono'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label for="correo"><i class="fas fa-envelope"></i> Correo Electrónico</label>
                    <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($cliente['correo'] ?? ''); ?>">
                </div>
            </div>
            <?php if ($isEditing): ?>
            <div class="form-row">
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="estado" name="estado" value="1" <?php echo isset($cliente['estado']) && $cliente['estado'] ? 'checked' : ''; ?>>
                        <label for="estado"><i class="fas fa-toggle-on"></i> Estado (Activo)</label>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-actions">
                <a href="<?php echo BASE_URL; ?>views/clientes_list.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Cliente' : 'Crear Cliente'; ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/include/footer.php'; ?>
