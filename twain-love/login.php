<?php
session_start();
if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true) {
    header('Location: bienvenida.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Inicio de sesión</title>
  <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .login-container {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 300px;
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
    }

    button {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        background-color: #007bff;
        color: white;
        font-weight: bold;
        font-size: 14px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-msg {
        color: red;
        margin-bottom: 10px;
    }

    .volver-btn {
        background-color: #6c757d;
    }

    .volver-btn:hover {
        background-color: #5a6268;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Iniciar sesión</h2>

    <?php if (isset($_GET['error'])): ?>
      <p class="error-msg">Usuario o contraseña incorrectos</p>
    <?php endif; ?>

    <form action="validar.php" method="post">
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>

    <!-- Botón Volver -->
    <form action="./index.php" method="get">
      <button type="submit" class="volver-btn">Volver</button>
    </form>
  </div>
</body>
</html>
