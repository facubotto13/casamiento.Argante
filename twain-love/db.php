<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "casamiento_argante";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
