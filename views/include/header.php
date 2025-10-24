<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Gestión de Celulares</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h1><i class="fas fa-mobile-alt"></i> Gestión de Celulares</h1>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?php echo BASE_URL; ?>views/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="<?php echo BASE_URL; ?>views/celulares_list.php"><i class="fas fa-mobile-alt"></i> Celulares</a></li>
            <li><a href="<?php echo BASE_URL; ?>views/usuarios_list.php"><i class="fas fa-users-cog"></i> Gestionar Usuarios</a></li>
            
            <li><a href="<?php echo BASE_URL; ?>views/clientes_list.php"><i class="fas fa-users"></i> Ver Todos los clientes</a></li>
            <li><a href="<?php echo BASE_URL; ?>views/tokens_list.php"><i class="fas fa-key"></i> Ver Todos los tokens</a></li>
            
                  <li><a href="<?php echo BASE_URL; ?>api_cliente"><i class="fas fa-external-link-alt" class="btn btn-primary"></i > Probar API Cliente</a></li>
                

            <li><a href="<?php echo BASE_URL; ?>public/index.php?action=logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
        </ul>
    </div>
    <div class="main-content">
        <main>


        <!-- En tu header.php -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header.css">

<?php
// Detectar la página actual para cargar CSS específico
$current_page = basename($_SERVER['PHP_SELF']);
switch($current_page) {
    case 'celulares_list.php':
        echo '<link rel="stylesheet" href="' . BASE_URL . 'assets/css/celulares_list.css">';
        break;
    case 'celular_form.php':
        echo '<link rel="stylesheet" href="' . BASE_URL . 'assets/css/celular_form.css">';
        break;
    case 'dashboard.php':
        echo '<link rel="stylesheet" href="' . BASE_URL . 'assets/css/dashboard.css">';
        break;
}
?>
<!-- Al final del header.php -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.createElement('div');
    overlay.classList.add('sidebar-overlay');
    document.body.appendChild(overlay);
    
    const toggleBtn = document.createElement('button');
    toggleBtn.classList.add('sidebar-toggle');
    toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    document.body.appendChild(toggleBtn);
    
    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
        document.body.classList.toggle('sidebar-open');
    });
    
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.classList.remove('sidebar-open');
    });
});
</script>