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
    require_once __DIR__ . '/../controllers/CelularController.php';
    $celularController = new CelularController();
    if ($celularController->borrarCelular($_GET['delete'])) {
        $mensaje = "✅ Celular eliminado exitosamente";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "❌ Error al eliminar el celular";
        $tipo_mensaje = "error";
    }
}

// Obtener lista de celulares
require_once __DIR__ . '/../controllers/CelularController.php';
$celularController = new CelularController();

// Configuración de paginación
$celularesPorPagina = 10;
$totalCelulares = $celularController->contarCelulares();
$totalPaginas = ceil($totalCelulares / $celularesPorPagina);
$paginaActual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;
$offset = ($paginaActual - 1) * $celularesPorPagina;

// Filtros de búsqueda
$filtroIMEI = isset($_GET['imei']) ? trim($_GET['imei']) : '';
$filtroNumeroSerie = isset($_GET['numero_serie']) ? trim($_GET['numero_serie']) : '';
$filtroModelo = isset($_GET['modelo']) ? trim($_GET['modelo']) : '';

// Obtener todos los celulares para aplicar los filtros
$todosLosCelulares = $celularController->listarCelulares();

// Aplicar filtros
$celularesFiltrados = [];
foreach ($todosLosCelulares as $celular) {
    $coincideIMEI = empty($filtroIMEI) || stripos($celular['imei'], $filtroIMEI) !== false;
    $coincideNumeroSerie = empty($filtroNumeroSerie) || stripos($celular['numero_serie'], $filtroNumeroSerie) !== false;
    $coincideModelo = empty($filtroModelo) || stripos($celular['modelo'], $filtroModelo) !== false;

    if ($coincideIMEI && $coincideNumeroSerie && $coincideModelo) {
        $celularesFiltrados[] = $celular;
    }
}

// Calcular paginación para los celulares filtrados
$totalCelularesFiltrados = count($celularesFiltrados);
$totalPaginasFiltradas = ceil($totalCelularesFiltrados / $celularesPorPagina);

// Obtener los celulares de la página actual después de aplicar los filtros
$celularesPaginados = array_slice($celularesFiltrados, $offset, $celularesPorPagina);

require_once __DIR__ . '/include/header.php';
?>

<div class="contenedor">
    <?php if (isset($mensaje)): ?>
        <div class="mensaje <?= $tipo_mensaje; ?>">
            <i class="fas <?= $tipo_mensaje == 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'; ?>"></i>
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
    <div class="acciones">
        <h3><i class="fas fa-mobile-alt"></i> Gestión de Celulares</h3>
        <a href="<?php echo BASE_URL; ?>views/celular_form.php"><i class="fas fa-plus-circle"></i> Agregar Nuevo Celular</a>
    </div>
    <!-- Filtros de búsqueda -->
    <form method="GET" action="<?php echo BASE_URL; ?>views/celulares_list.php" class="filtros">
        <input type="hidden" name="pagina" value="1">
        <div>
            <label for="imei"><i class="fas fa-search"></i> Buscar por IMEI:</label>
            <input type="text" id="imei" name="imei" value="<?php echo htmlspecialchars($filtroIMEI); ?>" placeholder="Ingrese IMEI del celular">
        </div>
        <div>
            <label for="numero_serie"><i class="fas fa-search"></i> Buscar por Número de Serie:</label>
            <input type="text" id="numero_serie" name="numero_serie" value="<?php echo htmlspecialchars($filtroNumeroSerie); ?>" placeholder="Ingrese número de serie del celular">
        </div>
        <div>
            <label for="modelo"><i class="fas fa-search"></i> Buscar por modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo htmlspecialchars($filtroModelo); ?>" placeholder="Ingrese modelo del celular">
        </div>
        <button type="submit"><i class="fas fa-filter"></i> Buscar</button>
        <a href="<?php echo BASE_URL; ?>views/celulares_list.php"><i class="fas fa-times"></i> Limpiar</a>
    </form>
    <?php if (empty($celularesPaginados)): ?>
        <div class="mensaje error">
            <i class="fas fa-info-circle"></i> No se encontraron celulares.
            <a href="<?php echo BASE_URL; ?>views/celular_form.php" style="margin-left:10px; color:#27ae60;">
                <i class="fas fa-plus-circle"></i> Agregar Primer Celular
            </a>
        </div>
    <?php else: ?>
        <div class="table-container">
            <table id="celularesTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><i class="fas fa-barcode"></i> IMEI</th>
                        <th><i class="fas fa-tag"></i> Número de Serie</th>
                        <th><i class="fas fa-industry"></i> Marca</th>
                        <th><i class="fas fa-mobile-alt"></i> Modelo</th>
                        <th><i class="fas fa-microchip"></i> Procesador</th>
                        <th><i class="fas fa-tv"></i> Pantalla</th>
                        <th><i class="fas fa-camera"></i> Cámara Principal (MP)</th>
                        <th><i class="fas fa-camera"></i> Cámara Frontal (MP)</th>
                        <th><i class="fas fa-battery-full"></i> Batería (mAh)</th>
                        <th><i class="fas fa-bolt"></i> Carga Rápida</th>
                        <th><i class="fas fa-memory"></i> RAM (GB)</th>
                        <th><i class="fas fa-hdd"></i> Almacenamiento (GB)</th>
                        <th><i class="fas fa-mobile-alt"></i> Sistema Operativo</th>
                        <th><i class="fas fa-wifi"></i> 5G</th>
                        <th><i class="fas fa-wifi"></i> NFC</th>
                        <th><i class="fas fa-usb"></i> Puerto USB</th>
                        <th><i class="fas fa-sim-card"></i> Dual SIM</th>
                        <th><i class="fas fa-weight"></i> Peso (g)</th>
                        <th><i class="fas fa-ruler-vertical"></i> Grosor (mm)</th>
                        <th><i class="fas fa-dollar-sign"></i> Precio (S/)</th>
                        <th><i class="fas fa-calendar"></i> Fecha de Lanzamiento</th>
                        <th><i class="fas fa-cogs"></i> Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = $offset + 1; ?>
                    <?php foreach ($celularesPaginados as $celular): ?>
                        <tr>
                            <td><?php echo $contador++; ?></td>
                            <td><?php echo htmlspecialchars($celular['imei']); ?></td>
                            <td><?php echo htmlspecialchars($celular['numero_serie']); ?></td>
                            <td><?php echo htmlspecialchars($celular['marca']); ?></td>
                            <td><?php echo htmlspecialchars($celular['modelo']); ?></td>
                            <td><?php echo htmlspecialchars($celular['procesador']); ?></td>
                            <td><?php echo htmlspecialchars($celular['pantalla']); ?></td>
                            <td><?php echo htmlspecialchars($celular['camara_principal_mpx']); ?></td>
                            <td><?php echo htmlspecialchars($celular['camara_frontal_mpx']); ?></td>
                            <td><?php echo htmlspecialchars($celular['bateria_mah']); ?></td>
                            <td><?php echo $celular['carga_rapida'] ? 'Sí' : 'No'; ?></td>
                            <td><?php echo htmlspecialchars($celular['ram_gb']); ?></td>
                            <td><?php echo htmlspecialchars($celular['almacenamiento_gb']); ?></td>
                            <td><?php echo htmlspecialchars($celular['sistema_operativo']); ?></td>
                            <td><?php echo $celular['conectividad_5g'] ? 'Sí' : 'No'; ?></td>
                            <td><?php echo $celular['nfc'] ? 'Sí' : 'No'; ?></td>
                            <td><?php echo htmlspecialchars($celular['puerto_usb']); ?></td>
                            <td><?php echo $celular['dual_sim'] ? 'Sí' : 'No'; ?></td>
                            <td><?php echo htmlspecialchars($celular['peso_gramos']); ?></td>
                            <td><?php echo htmlspecialchars($celular['grosor_mm']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($celular['precio_usd'] * 3.7, 2)); ?></td>
                            <td>
                                <?php
                                if (!empty($celular['fecha_lanzamiento']) && $celular['fecha_lanzamiento'] !== '0000-00-00') {
                                    echo htmlspecialchars(date('d/m/Y', strtotime($celular['fecha_lanzamiento'])));
                                } else {
                                    echo '<span style="color: #999; font-style: italic;">No especificada</span>';
                                }
                                ?>
                            </td>
                            <td class="acciones-tabla">
                                <a href="<?php echo BASE_URL; ?>views/celular_form.php?edit=<?php echo $celular['id']; ?>">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <a href="#" class="eliminar" onclick="confirmarEliminacion(<?php echo $celular['id']; ?>, '<?php echo addslashes($celular['marca'] . ' ' . $celular['modelo']); ?>', <?php echo $paginaActual; ?>, '<?php echo urlencode($filtroIMEI); ?>', '<?php echo urlencode($filtroNumeroSerie); ?>', '<?php echo urlencode($filtroModelo); ?>')">
                                    <i class="fas fa-trash-alt"></i> Eliminar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="paginacion">
            <?php if ($paginaActual > 1): ?>
                <a href="<?php echo BASE_URL; ?>views/celulares_list.php?pagina=<?php echo $paginaActual - 1; ?><?php echo (!empty($filtroIMEI) || !empty($filtroNumeroSerie) || !empty($filtroModelo)) ? '&imei=' . urlencode($filtroIMEI) . '&numero_serie=' . urlencode($filtroNumeroSerie) . '&modelo=' . urlencode($filtroModelo) : ''; ?>">
                    <i class="fas fa-arrow-left"></i> Anterior
                </a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPaginasFiltradas; $i++): ?>
                <a href="<?php echo BASE_URL; ?>views/celulares_list.php?pagina=<?php echo $i; ?><?php echo (!empty($filtroIMEI) || !empty($filtroNumeroSerie) || !empty($filtroModelo)) ? '&imei=' . urlencode($filtroIMEI) . '&numero_serie=' . urlencode($filtroNumeroSerie) . '&modelo=' . urlencode($filtroModelo) : ''; ?>" class="<?= $i === $paginaActual ? 'activa' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            <?php if ($paginaActual < $totalPaginasFiltradas): ?>
                <a href="<?php echo BASE_URL; ?>views/celulares_list.php?pagina=<?php echo $paginaActual + 1; ?><?php echo (!empty($filtroIMEI) || !empty($filtroNumeroSerie) || !empty($filtroModelo)) ? '&imei=' . urlencode($filtroIMEI) . '&numero_serie=' . urlencode($filtroNumeroSerie) . '&modelo=' . urlencode($filtroModelo) : ''; ?>">
                    Siguiente <i class="fas fa-arrow-right"></i>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<script>
    function confirmarEliminacion(id, nombre, pagina, filtroIMEI, filtroNumeroSerie, filtroModelo) {
        if (confirm(`¿Estás seguro de que deseas eliminar el celular "${nombre}"?`)) {
            window.location.href = `<?php echo BASE_URL; ?>views/celulares_list.php?delete=${id}&pagina=${pagina}&imei=${filtroIMEI}&numero_serie=${filtroNumeroSerie}&modelo=${filtroModelo}`;
        }
    }
</script>

<?php require_once __DIR__ . '/include/footer.php'; ?>
