<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

require_once __DIR__ . '/../controllers/CelularController.php';
$celularController = new CelularController();

// Determinar si es edición o creación
$isEditing = isset($_GET['edit']) && is_numeric($_GET['edit']);
$celular = null;
$pageTitle = $isEditing ? 'Editar Celular' : 'Agregar Nuevo Celular';

if ($isEditing) {
    $celular = $celularController->obtenerCelular($_GET['edit']);
    if (!$celular) {
        header('Location: ' . BASE_URL . 'views/celulares_list.php');
        exit();
    }
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imei = trim($_POST['imei']);
    $numero_serie = trim($_POST['numero_serie']);
    $marca = trim($_POST['marca']);
    $modelo = trim($_POST['modelo']);
    $procesador = trim($_POST['procesador']);
    $pantalla = trim($_POST['pantalla']);
    $camara_principal_mpx = intval($_POST['camara_principal_mpx']);
    $camara_frontal_mpx = intval($_POST['camara_frontal_mpx']);
    $bateria_mah = intval($_POST['bateria_mah']);
    $carga_rapida = isset($_POST['carga_rapida']) ? 1 : 0;
    $ram_gb = intval($_POST['ram_gb']);
    $almacenamiento_gb = intval($_POST['almacenamiento_gb']);
    $sistema_operativo = trim($_POST['sistema_operativo']);
    $conectividad_5g = isset($_POST['conectividad_5g']) ? 1 : 0;
    $nfc = isset($_POST['nfc']) ? 1 : 0;
    $puerto_usb = trim($_POST['puerto_usb']);
    $dual_sim = isset($_POST['dual_sim']) ? 1 : 0;
    $peso_gramos = intval($_POST['peso_gramos']);
    $grosor_mm = floatval($_POST['grosor_mm']);
    $precio_usd = floatval($_POST['precio_usd']);
    $fecha_lanzamiento = !empty(trim($_POST['fecha_lanzamiento'])) ? trim($_POST['fecha_lanzamiento']) : null;

    // Validaciones
    $errores = [];
    if (empty($imei)) $errores[] = "El campo IMEI es obligatorio";
    if (empty($numero_serie)) $errores[] = "El campo Número de Serie es obligatorio";
    if (empty($marca)) $errores[] = "El campo Marca es obligatorio";
    if (empty($modelo)) $errores[] = "El campo Modelo es obligatorio";

    if (empty($errores)) {
        if ($isEditing) {
            $resultado = $celularController->editarCelular(
                $_GET['edit'],
                $imei,
                $numero_serie,
                $marca,
                $modelo,
                $procesador,
                $pantalla,
                $camara_principal_mpx,
                $camara_frontal_mpx,
                $bateria_mah,
                $carga_rapida,
                $ram_gb,
                $almacenamiento_gb,
                $sistema_operativo,
                $conectividad_5g,
                $nfc,
                $puerto_usb,
                $dual_sim,
                $peso_gramos,
                $grosor_mm,
                $precio_usd,
                $fecha_lanzamiento
            );
            $mensaje = $resultado ? "✅ Celular actualizado exitosamente" : "❌ Error al actualizar el celular";
            $tipo_mensaje = $resultado ? "success" : "error";
            $celular = $celularController->obtenerCelular($_GET['edit']);
        } else {
            $resultado = $celularController->crearCelular(
                $imei,
                $numero_serie,
                $marca,
                $modelo,
                $procesador,
                $pantalla,
                $camara_principal_mpx,
                $camara_frontal_mpx,
                $bateria_mah,
                $carga_rapida,
                $ram_gb,
                $almacenamiento_gb,
                $sistema_operativo,
                $conectividad_5g,
                $nfc,
                $puerto_usb,
                $dual_sim,
                $peso_gramos,
                $grosor_mm,
                $precio_usd,
                $fecha_lanzamiento
            );
            if ($resultado) {
                header('Location: ' . BASE_URL . 'views/celulares_list.php?created=1');
                exit();
            } else {
                $mensaje = "❌ Error al crear el celular";
                $tipo_mensaje = "error";
            }
        }
    }
}

require_once __DIR__ . '/include/header.php';
?>

<style>
    .form-container {
        padding: 20px;
        max-width: 1000px;
        margin: 0 auto;
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-actions h2 {
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-actions a {
        padding: 8px 15px;
        background: #95a5a6;
        color: white;
        border-radius: 5px;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        transition: background 0.3s;
    }

    .form-actions a:hover {
        background: #7f8c8d;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 5px;
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
        font-weight: bold;
        color: #2c3e50;
    }

    .form-group input[type="text"],
    .form-group input[type="number"],
    .form-group input[type="date"],
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 1rem;
    }

    .form-group input[type="checkbox"] {
        margin-right: 10px;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-actions-bottom {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-secondary {
        background: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
    }

    .btn-primary {
        background: #2ecc71;
        color: white;
    }

    .btn-primary:hover {
        background: #27ae60;
    }

    @media (max-width: 768px) {
        .form-group {
            flex: 1 1 100%;
        }
    }
</style>

<div class="form-container">
    <div class="form-actions">
        <h2><i class="fas fa-mobile-alt"></i> <?php echo $pageTitle; ?></h2>
        <a href="<?php echo BASE_URL; ?>views/celulares_list.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
    </div>

    <?php if (isset($mensaje)): ?>
        <div class="alert-<?php echo $tipo_mensaje; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert-error">
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
                <label for="imei"><i class="fas fa-barcode"></i> IMEI *</label>
                <input type="text" id="imei" name="imei" value="<?php echo htmlspecialchars($celular['imei'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="numero_serie"><i class="fas fa-tag"></i> Número de Serie *</label>
                <input type="text" id="numero_serie" name="numero_serie" value="<?php echo htmlspecialchars($celular['numero_serie'] ?? ''); ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="marca"><i class="fas fa-industry"></i> Marca *</label>
                <input type="text" id="marca" name="marca" value="<?php echo htmlspecialchars($celular['marca'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="modelo"><i class="fas fa-mobile-alt"></i> Modelo *</label>
                <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($celular['modelo'] ?? ''); ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="procesador"><i class="fas fa-microchip"></i> Procesador</label>
                <input type="text" id="procesador" name="procesador" value="<?php echo htmlspecialchars($celular['procesador'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="pantalla"><i class="fas fa-tv"></i> Pantalla</label>
                <input type="text" id="pantalla" name="pantalla" value="<?php echo htmlspecialchars($celular['pantalla'] ?? ''); ?>" placeholder="Ej: 6.5&quot; AMOLED, FHD+">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="camara_principal_mpx"><i class="fas fa-camera"></i> Cámara Principal (MP)</label>
                <input type="number" id="camara_principal_mpx" name="camara_principal_mpx" value="<?php echo htmlspecialchars($celular['camara_principal_mpx'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="camara_frontal_mpx"><i class="fas fa-camera"></i> Cámara Frontal (MP)</label>
                <input type="number" id="camara_frontal_mpx" name="camara_frontal_mpx" value="<?php echo htmlspecialchars($celular['camara_frontal_mpx'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="bateria_mah"><i class="fas fa-battery-full"></i> Batería (mAh)</label>
                <input type="number" id="bateria_mah" name="bateria_mah" value="<?php echo htmlspecialchars($celular['bateria_mah'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="carga_rapida" name="carga_rapida" value="1" <?php echo isset($celular['carga_rapida']) && $celular['carga_rapida'] ? 'checked' : ''; ?>>
                    <label for="carga_rapida"><i class="fas fa-bolt"></i> Carga Rápida</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="ram_gb"><i class="fas fa-memory"></i> RAM (GB)</label>
                <input type="number" id="ram_gb" name="ram_gb" value="<?php echo htmlspecialchars($celular['ram_gb'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="almacenamiento_gb"><i class="fas fa-hdd"></i> Almacenamiento (GB)</label>
                <input type="number" id="almacenamiento_gb" name="almacenamiento_gb" value="<?php echo htmlspecialchars($celular['almacenamiento_gb'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="sistema_operativo"><i class="fas fa-mobile-alt"></i> Sistema Operativo</label>
                <input type="text" id="sistema_operativo" name="sistema_operativo" value="<?php echo htmlspecialchars($celular['sistema_operativo'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="conectividad_5g" name="conectividad_5g" value="1" <?php echo isset($celular['conectividad_5g']) && $celular['conectividad_5g'] ? 'checked' : ''; ?>>
                    <label for="conectividad_5g"><i class="fas fa-wifi"></i> Conectividad 5G</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="nfc" name="nfc" value="1" <?php echo isset($celular['nfc']) && $celular['nfc'] ? 'checked' : ''; ?>>
                    <label for="nfc"><i class="fas fa-wifi"></i> NFC</label>
                </div>
            </div>
            <div class="form-group">
                <label for="puerto_usb"><i class="fas fa-usb"></i> Puerto USB</label>
                <select id="puerto_usb" name="puerto_usb">
                    <option value="USB-C" <?php echo (isset($celular['puerto_usb']) && $celular['puerto_usb'] === 'USB-C') ? 'selected' : ''; ?>>USB-C</option>
                    <option value="micro-USB" <?php echo (isset($celular['puerto_usb']) && $celular['puerto_usb'] === 'micro-USB') ? 'selected' : ''; ?>>micro-USB</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="checkbox-group">
                    <input type="checkbox" id="dual_sim" name="dual_sim" value="1" <?php echo isset($celular['dual_sim']) && $celular['dual_sim'] ? 'checked' : ''; ?>>
                    <label for="dual_sim"><i class="fas fa-sim-card"></i> Dual SIM</label>
                </div>
            </div>
            <div class="form-group">
                <label for="peso_gramos"><i class="fas fa-weight"></i> Peso (gramos)</label>
                <input type="number" id="peso_gramos" name="peso_gramos" value="<?php echo htmlspecialchars($celular['peso_gramos'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="grosor_mm"><i class="fas fa-ruler-vertical"></i> Grosor (mm)</label>
                <input type="number" step="0.1" id="grosor_mm" name="grosor_mm" value="<?php echo htmlspecialchars($celular['grosor_mm'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="precio_usd"><i class="fas fa-dollar-sign"></i> Precio (USD)</label>
                <input type="number" step="0.01" id="precio_usd" name="precio_usd" value="<?php echo htmlspecialchars($celular['precio_usd'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="fecha_lanzamiento"><i class="fas fa-calendar"></i> Fecha de Lanzamiento</label>
                <input type="date" id="fecha_lanzamiento" name="fecha_lanzamiento" value="<?php echo htmlspecialchars($celular['fecha_lanzamiento'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-actions-bottom">
            <a href="<?php echo BASE_URL; ?>views/celulares_list.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> <?php echo $isEditing ? 'Actualizar Celular' : 'Crear Celular'; ?></button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/include/footer.php'; ?>
