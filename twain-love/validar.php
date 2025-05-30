<?php
session_start();

// Datos fijos para un solo usuario
$usuario_valido = 'admin';
$contrasena_valida = '1234';

if ($_POST['usuario'] === $usuario_valido && $_POST['contrasena'] === $contrasena_valida) {
    $_SESSION['logueado'] = true;
    header('Location: bienvenida.php');
    exit;
} else {
    header('Location: login.php?error=1');
    exit;
}
?>
