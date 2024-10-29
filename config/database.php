<?php

$userName = "";
$password = "";
$dsn = "oci:dbname=//localhost:1521/XEPDB1"; // Ajusta a tu configuración de Oracle

try {
    $conexion = new PDO($dsn, $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
