<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

// Verificar si ya hay sesión activa
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar Sesión - Sistema de Gestión</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    :root {
      --primary-color: #2c3e50;
      --primary-hover: #1a252f;
      --secondary-color: #3498db;
      --accent-color: #e74c3c;
      --background-color: #ecf0f1;
      --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      --input-border: #bdc3c7;
      --input-focus: rgba(46, 204, 113, 0.1);
      --error-color: #e74c3c;
      --success-color: #2ecc71;
      --text-color: #2c3e50;
      --light-text: #7f8c8d;
      --border-radius: 12px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
      background: var(--background-color);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      color: var(--text-color);
      background-image: linear-gradient(135deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.9) 100%);
    }

    .auth-container {
      width: 100%;
      max-width: 450px;
      position: relative;
    }

    .auth-card {
      background: white;
      width: 100%;
      padding: 2.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--card-shadow);
      position: relative;
      z-index: 1;
      overflow: hidden;
      transition: transform 0.3s ease;
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .auth-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 12px;
      background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .auth-title {
      text-align: center;
      margin-bottom: 2rem;
      font-size: 1.8rem;
      font-weight: 600;
      color: var(--primary-color);
      position: relative;
    }

    .auth-title::after {
      content: '';
      display: block;
      width: 50px;
      height: 4px;
      background: var(--secondary-color);
      margin: 12px auto 0;
      border-radius: 2px;
    }

    .auth-icon {
      display: flex;
      justify-content: center;
      margin-bottom: 1.5rem;
    }

    .auth-icon i {
      font-size: 3rem;
      color: var(--secondary-color);
      background: rgba(52, 152, 219, 0.1);
      padding: 20px;
      border-radius: 50%;
    }

    /* Alertas */
    .alert {
      padding: 14px 18px;
      border-radius: var(--border-radius);
      margin-bottom: 1.5rem;
      font-size: 0.95rem;
      display: flex;
      align-items: center;
      animation: fadeIn 0.4s ease;
      border-left: 4px solid;
    }

    .alert i {
      margin-right: 10px;
      font-size: 1.1rem;
    }

    .alert-success {
      background: rgba(46, 204, 113, 0.1);
      color: var(--success-color);
      border-left-color: var(--success-color);
    }

    .alert-error {
      background: rgba(231, 76, 60, 0.1);
      color: var(--error-color);
      border-left-color: var(--error-color);
    }

    /* Form */
    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-input-container {
      position: relative;
    }

    .form-input {
      width: 100%;
      padding: 14px 16px 14px 45px;
      border: 1px solid var(--input-border);
      border-radius: 10px;
      font-size: 1rem;
      transition: all 0.3s ease;
      background: #fafafa;
      color: var(--text-color);
    }

    .form-input:focus {
      outline: none;
      border-color: var(--secondary-color);
      box-shadow: 0 0 0 3px var(--input-focus);
      background: #fff;
    }

    .form-input-icon {
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--light-text);
      font-size: 1.1rem;
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--primary-color);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 0.5rem;
    }

    .btn-submit:hover {
      background: var(--primary-hover);
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(44, 62, 80, 0.2);
    }

    .btn-submit:active {
      transform: translateY(0);
    }

    .btn-submit i {
      margin-right: 8px;
    }

    .forgot-password {
      text-align: center;
      margin-top: 1.2rem;
    }

    .forgot-password a {
      color: var(--secondary-color);
      text-decoration: none;
      font-size: 0.9rem;
      transition: color 0.3s;
    }

    .forgot-password a:hover {
      color: var(--primary-hover);
      text-decoration: underline;
    }

    .footer-info {
      text-align: center;
      margin-top: 2rem;
      font-size: 0.85rem;
      color: var(--light-text);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 480px) {
      .auth-card {
        padding: 1.8rem;
      }

      .auth-title {
        font-size: 1.6rem;
        margin-bottom: 1.5rem;
      }
    }

    /* Efecto de fondo */
    .auth-container::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        to bottom right,
        rgba(52, 152, 219, 0.05) 0%,
        rgba(52, 152, 219, 0.02) 50%,
        transparent 100%
      );
      transform: rotate(-5deg);
      pointer-events: none;
      z-index: 0;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-icon">
        <i class="fas fa-mobile-alt"></i>
      </div>
      <h2 class="auth-title">Iniciar Sesión</h2>

      <!-- Mensajes -->
      <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
        <div class="alert alert-success">
          <i class="fas fa-check-circle"></i>
          ✅ Sesión cerrada exitosamente
        </div>
      <?php endif; ?>

      <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div class="alert alert-error">
          <i class="fas fa-exclamation-circle"></i>
          ❌ Usuario o contraseña incorrectos
        </div>
      <?php endif; ?>

      <form action="<?php echo BASE_URL; ?>public/index.php?action=login" method="POST">
        <div class="form-group">
          <div class="form-input-container">
            <i class="fas fa-user form-input-icon"></i>
            <input type="text" name="username" class="form-input" placeholder="Nombre de usuario" required>
          </div>
        </div>

        <div class="form-group">
          <div class="form-input-container">
            <i class="fas fa-lock form-input-icon"></i>
            <input type="password" name="password" class="form-input" placeholder="Contraseña" required>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="fas fa-sign-in-alt"></i>
          Ingresar
        </button>
      </form>

      <div class="footer-info">
        <p>Sistema de Gestión © <?php echo date('Y'); ?></p>
      </div>
    </div>
  </div>
</body>
</html>
