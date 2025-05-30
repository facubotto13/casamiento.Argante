<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $pagado = isset($_POST['pagado']) ? (int)$_POST['pagado'] : 0;

    // Actualizar en la base de datos
    $stmt = $conn->prepare("UPDATE asistentes SET pagado = ? WHERE nombre = ?");
    $stmt->bind_param('is', $pagado, $nombre);
    
    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "Error al actualizar";
    }
}
