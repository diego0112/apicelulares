<?php
// api_handler.php (APICELULARES)
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TokenApiController.php';
require_once __DIR__ . '/controllers/CelularController.php';

// Obtener el token y la acción
$token = $_POST['token'] ?? '';
$action = $_GET['action'] ?? '';

// Validar el token en APICELULARES
if ($action === 'validarToken') {
    $tokenController = new TokenApiController();
    $tokenData = $tokenController->obtenerTokenPorToken($token);

    if (!$tokenData) {
        echo json_encode([
            'status' => false,
            'type' => 'error',
            'msg' => 'Token no encontrado en APICELULARES.'
        ]);
        exit();
    }

    if ($tokenData['estado'] != 1) {
        echo json_encode([
            'status' => false,
            'type' => 'warning',
            'msg' => 'Token inactivo en APICELULARES.'
        ]);
        exit();
    }

    echo json_encode([
        'status' => true,
        'type' => 'success',
        'msg' => 'Token válido en APICELULARES.'
    ]);
    exit();
}

// Procesar otras acciones (buscarCelulares, etc.)
$tokenController = new TokenApiController();
$tokenData = $tokenController->obtenerTokenPorToken($token);

if (!$tokenData) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no encontrado en APICELULARES.'
    ]);
    exit();
}

if ($tokenData['estado'] != 1) {
    echo json_encode([
        'status' => false,
        'type' => 'warning',
        'msg' => 'Token inactivo en APICELULARES.'
    ]);
    exit();
}

// Procesar la acción (ej: buscarCelulares)
switch ($action) {
    case 'buscarCelulares':
        $celularController = new CelularController();
        $search = $_POST['search'] ?? '';
        $celulares = $celularController->buscarCelulares($search);
        echo json_encode([
            'status' => true,
            'type' => 'success',
            'data' => $celulares
        ]);
        break;
    default:
        echo json_encode([
            'status' => false,
            'type' => 'error',
            'msg' => 'Acción no válida.'
        ]);
}
?>
