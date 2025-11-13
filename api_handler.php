<?php
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TokenApiController.php';
require_once __DIR__ . '/controllers/CelularController.php';

// Obtener el token y la acción
$token = $_POST['token'] ?? '';
$action = $_GET['action'] ?? '';

// Validar que el token no esté vacío
if (empty($token)) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no proporcionado.'
    ]);
    exit();
}

// Validar el token en la base de datos de APICELULARES
$tokenController = new TokenApiController();
$tokenData = $tokenController->obtenerTokenPorToken($token);

if (!$tokenData) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no encontrado en la base de datos de APICELULARES.'
    ]);
    exit();
}

if ($tokenData['estado'] != 1) {
    echo json_encode([
        'status' => false,
        'type' => 'warning',
        'msg' => 'Token inactivo en la base de datos de APICELULARES.'
    ]);
    exit();
}

// Procesar la acción
$celularController = new CelularController();
switch ($action) {
    case 'buscarCelulares':
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
