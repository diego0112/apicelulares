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
$totalCelulares = count($celularController->listarCelulares());
$celularesRecientes = array_slice($celularController->listarCelulares(), -8);

require_once __DIR__ . '/include/header.php';
?>

<style>
    /* Estilos para el dashboard */
    .dashboard-container {
        padding: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .welcome-section {
        margin-bottom: 20px;
    }

    .welcome-title {
        font-size: 1.8rem;
        margin-bottom: 10px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dashboard-cards {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 20px;
    }

    .card {
        flex: 1 1 calc(33.333% - 20px);
        min-width: 250px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    .card h3 {
        color: #3498db;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card p {
        margin-bottom: 10px;
        font-size: 1rem;
    }

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .quick-actions a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
        transition: background 0.3s;
        text-decoration: none;
        color: #2c3e50;
    }

    .quick-actions a:hover {
        background: #e9ecef;
    }

    @media (max-width: 768px) {
        .card {
            flex: 1 1 calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .card {
            flex: 1 1 100%;
        }
    }

    /* Estilos para los celulares recientes */
    .recent-celulares-section {
        margin-top: 30px;
    }

    .recent-celulares-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .recent-celulares-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .celular-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        transition: transform 0.3s ease;
    }

    .celular-card:hover {
        transform: translateY(-5px);
    }

    .celular-card h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .celular-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .celular-detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.9rem;
        color: #7f8c8d;
    }

    .celular-detail-item i {
        color: #3498db;
        width: 16px;
    }
</style>

<div class="dashboard-container">
    <div class="welcome-section">
        <h2 class="welcome-title">
            <i class="fas fa-mobile-alt"></i> ¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? $_SESSION['username']); ?>!
        </h2>
    </div>

    <div class="dashboard-cards">
        <!-- Información de la Sesión -->
        <div class="card">
            <h3><i class="fas fa-user-shield"></i> Información de la Sesión</h3>
            <p><strong>ID:</strong> <?php echo $_SESSION['user_id']; ?></p>
            <p><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p><strong>Rol:</strong> <?php echo strtoupper($_SESSION['rol'] ?? 'ADMIN'); ?></p>
        </div>

        <!-- Estadísticas -->
        <div class="card">
            <h3><i class="fas fa-chart-line"></i> Estadísticas</h3>
            <p>Total de celulares registrados: <strong><?php echo $totalCelulares; ?></strong></p>
        </div>

        <!-- Acciones Rápidas -->
        <div class="card">
            <h3><i class="fas fa-bolt"></i> Acciones Rápidas</h3>
            <div class="quick-actions">
                <a href="<?php echo BASE_URL; ?>views/celulares_list.php">
                    <i class="fas fa-list"></i> Ver Todos los Celulares
                </a>
                <a href="<?php echo BASE_URL; ?>views/celular_form.php">
                    <i class="fas fa-plus-circle"></i> Agregar Nuevo Celular
                </a>
                <a href="<?php echo BASE_URL; ?>views/clientes_list.php">
                    <i class="fas fa-users"></i> Ver Todos los clientes
                </a>
                <a href="<?php echo BASE_URL; ?>views/tokens_list.php">
                    <i class="fas fa-key"></i> Ver Todos los tokens
                </a>
            </div>
        </div>
    </div>

    <!-- Celulares Registrados Recientemente -->
    <?php if (!empty($celularesRecientes)): ?>
        <div class="recent-celulares-section">
            <h3 class="recent-celulares-title">
                <i class="fas fa-clock"></i> Celulares Registrados Recientemente
            </h3>
            <div class="recent-celulares-grid">
                <?php
                $celularesRecientes = array_reverse($celularesRecientes);
                foreach ($celularesRecientes as $celular): ?>
                    <div class="celular-card">
                        <h4><i class="fas fa-mobile-alt"></i> <?php echo htmlspecialchars($celular['marca'] . ' ' . $celular['modelo']); ?></h4>
                        <div class="celular-details">
                            <div class="celular-detail-item">
                                <i class="fas fa-barcode"></i>
                                <span><?php echo htmlspecialchars($celular['imei']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-tag"></i>
                                <span><?php echo htmlspecialchars($celular['numero_serie']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-industry"></i>
                                <span><?php echo htmlspecialchars($celular['marca']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-mobile-alt"></i>
                                <span><?php echo htmlspecialchars($celular['modelo']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-microchip"></i>
                                <span><?php echo htmlspecialchars($celular['procesador']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-tv"></i>
                                <span><?php echo htmlspecialchars($celular['pantalla']); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-camera"></i>
                                <span><?php echo htmlspecialchars($celular['camara_principal_mpx'] . ' MP'); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-camera"></i>
                                <span><?php echo htmlspecialchars($celular['camara_frontal_mpx'] . ' MP'); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-battery-full"></i>
                                <span><?php echo htmlspecialchars($celular['bateria_mah'] . ' mAh'); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-bolt"></i>
                                <span><?php echo $celular['carga_rapida'] ? 'Sí' : 'No'; ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-memory"></i>
                                <span><?php echo htmlspecialchars($celular['ram_gb'] . ' GB'); ?></span>
                            </div>
                            <div class="celular-detail-item">
                                <i class="fas fa-hdd"></i>
                                <span><?php echo htmlspecialchars($celular['almacenamiento_gb'] . ' GB'); ?></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/include/footer.php'; ?>
