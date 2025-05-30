<?php
session_start();

if (!isset($_SESSION['logueado']) || $_SESSION['logueado'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Consulta para calcular los totales desde asistentes
$sql = "SELECT
    COUNT(*) AS cantidad_total,
    SUM(CASE WHEN edad = 'mayor' THEN 1 ELSE 0 END) AS cantidad_mayores,
    SUM(CASE WHEN edad = 'menor' THEN 1 ELSE 0 END) AS cantidad_menores,
    SUM(CASE WHEN alimentacion = 'normal' THEN 1 ELSE 0 END) AS cantidad_normal,
    SUM(CASE WHEN alimentacion = 'vegetariano' THEN 1 ELSE 0 END) AS cantidad_vegetariano,
    SUM(CASE WHEN alimentacion = 'vegano' THEN 1 ELSE 0 END) AS cantidad_vegano,
    SUM(CASE WHEN alimentacion = 'celiaco' THEN 1 ELSE 0 END) AS cantidad_celiaco,
    SUM(CASE WHEN asistencia = 'cena' THEN 1 ELSE 0 END) AS cantidad_cena,
    SUM(CASE WHEN asistencia = 'brindis' THEN 1 ELSE 0 END) AS cantidad_brindis,
    SUM(valor_tarjeta) AS suma_valores
FROM asistentes";


$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$data = $result->fetch_assoc();

// Si cantidad_brindis es diferente, cambia esta línea
$cantidad_brindis = $data['cantidad_brindis'];

// Usamos INSERT ... ON DUPLICATE KEY UPDATE
$sql_update = "INSERT INTO resumen_asistentes 
    (cantidad_cena, cantidad_brindis, cantidad_total, suma_valores, cantidad_normal, cantidad_vegetariano, cantidad_vegano, cantidad_celiaco, menores, mayores)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE
    cantidad_cena = VALUES(cantidad_cena),
    cantidad_brindis = VALUES(cantidad_brindis),
    cantidad_total = VALUES(cantidad_total),
    suma_valores = VALUES(suma_valores),
    menores = VALUES(menores),
    mayores = VALUES(mayores),
    cantidad_normal = VALUES(cantidad_normal),
    cantidad_vegetariano = VALUES(cantidad_vegetariano),
    cantidad_vegano = VALUES(cantidad_vegano),
    cantidad_celiaco = VALUES(cantidad_celiaco)";



$stmt = $conn->prepare($sql_update);

if (!$stmt) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param(
    "iiidiiiiii",  // Ahora son 10 tipos
    $data['cantidad_cena'], 
    $cantidad_brindis, 
    $data['cantidad_total'], 
    $data['suma_valores'], 
    $data['cantidad_normal'], 
    $data['cantidad_vegetariano'], 
    $data['cantidad_vegano'], 
    $data['cantidad_celiaco'],
    $data['cantidad_menores'], 
    $data['cantidad_mayores']
);


if ($stmt->execute()) {
    header("Location: bienvenida.php");
    exit;
} else {
    die("Error al actualizar resumen: " . $stmt->error);
}
