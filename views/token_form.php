<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}
require_once __DIR__ . '/../controllers/TokenApiController.php';
$tokenApiController = new TokenApiController();
// Determinar si es edición o creación
$isEditing = isset($_GET['edit']) && is_numeric($_GET['edit']);
$token = null;
$pageTitle = $isEditing ? 'Editar Token' : 'Generar Nuevo Token';
// Obtener clientes
$clientes = $tokenApiController->obtenerClientes();
if ($isEditing) {
    $token = $tokenApiController->obtenerToken($_GET['edit']);
    if (!$token) {
        header('Location: ' . BASE_URL . 'views/tokens_list.php');
        exit();
    }
}
// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client_api = trim($_POST['id_client_api']);
    $estado = $isEditing ? (isset($_POST['estado']) ? 1 : 0) : 1;
    // Validaciones
    $errores = [];
    if (empty($id_client_api)) $errores[] = "El campo Cliente es obligatorio";
    if (empty($errores)) {
        if ($isEditing) {
            $resultado = $tokenApiController->editarToken($_GET['edit'], $estado);
            $mensaje = $resultado ? "✅ Token actualizado exitosamente" : "❌ Error al actualizar el token";
            $tipo_mensaje = $resultado ? "success" : "error";
            $token = $tokenApiController->obtenerToken($_GET['edit']);
        } else {
            $resultado = $tokenApiController->crearToken($id_client_api);
            if ($resultado) {
                header('Location: ' . BASE_URL . 'views/tokens_list.php?created=1');
                exit();
            } else {
                $mensaje = "❌ Error al generar el token";
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
    .form-group select {
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
    .token-display {
        background: #f7fafc;
        padding: 1rem;
        border-radius: var(--border-radius);
        margin-top: 1rem;
        font-family: monospace;
        word-break: break-all;
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
                <i class="fas fa-key"></i> <?php echo $pageTitle; ?>
            </h2>
            <a href="<?php echo BASE_URL; ?>views/tokens_list.php" class="btn btn-secondary">
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
                    <label for="id_client_api"><i class="fas fa-building"></i> Cliente *</label>
                    <select id="id_client_api" name="id_client_api" required>
                        <option value="">-- Seleccione un cliente --</option>
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo $cliente['id']; ?>"
                                <?php echo ($isEditing && $token['id_client_api'] == $cliente['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cliente['razon_social']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <?php if ($isEditing): ?>
            <div class="form-row">
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="estado" name="estado" value="1" <?php echo isset($token['estado']) && $token['estado'] ? 'checked' : ''; ?>>
                        <label for="estado"><i class="fas fa-toggle-on"></i> Estado (Activo)</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label><i class="fas fa-key"></i> Token Generado</label>
                    <div class="token-display">
                        <?php echo htmlspecialchars($token['token']); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="form-actions">
                <a href="<?php echo BASE_URL; ?>views/tokens_list.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Token' : 'Generar Token'; ?>
                </button>
            </div>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/include/footer.php'; ?>

