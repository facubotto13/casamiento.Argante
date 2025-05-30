<?php
// Conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "casamiento_argante";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ver debug para revisar datos recibidos
// echo "<pre>";
// print_r($_POST);
// exit;

$cantidad = intval($_POST['numAsistentes']);

// Insertar en tabla rsvps
$stmt = $conn->prepare("INSERT INTO rsvps (cantidad_asistentes) VALUES (?)");
$stmt->bind_param("i", $cantidad);
$stmt->execute();
$rsvp_id = $stmt->insert_id;
$stmt->close();

// Insertar cada asistente
for ($i = 1; $i <= $cantidad; $i++) {
    $nombre = $_POST["nombre$i"] ?? '';
    $alimentacion = $_POST["alimentacion$i"] ?? '';
    $edad = $_POST["edad$i"] ?? '';
    $valor = floatval($_POST["valor_tarjeta$i"] ?? 0);

    // Normalizar strings si quieres
    $nombre = trim($nombre);
    $alimentacion = trim($alimentacion);
    $edad = trim($edad);

    // Insertar en asistentes
    $stmt = $conn->prepare("INSERT INTO asistentes (rsvp_id, nombre, alimentacion, edad, valor_tarjeta) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $rsvp_id, $nombre, $alimentacion, $edad, $valor);
    $stmt->execute();
    $stmt->close();
}

$conn->close();

// Mostrar mensaje (puedes mejorarlo con redirección o AJAX)
echo "<script>
    alert('Formulario enviado con éxito!');
    window.location.href = 'index.html'; // O la página que quieras
</script>";
?>
