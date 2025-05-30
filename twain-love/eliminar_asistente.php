<?php
require_once 'db.php';

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];

    $stmt = $conn->prepare("DELETE FROM asistentes WHERE nombre = ?");
    $stmt->bind_param("s", $nombre);

    if ($stmt->execute()) {
        echo "OK";
    } else {
        echo "ERROR";
    }

    $stmt->close();
    $conn->close();
}
?>
