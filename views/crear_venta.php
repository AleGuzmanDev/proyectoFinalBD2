<?php
include("../config/database.php"); // Asegúrate de que la conexión esté configurada correctamente

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $id_venta = $_POST['id_venta'];
    $id_afiliado = $_POST['id_afiliado'];
    $total_venta = $_POST['total_venta'];
    $fecha_venta = $_POST['fecha_venta'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Preparar la llamada al procedimiento
        $sql = "BEGIN 
                    crear_venta(:p_id_venta, :p_id_afiliado, :p_total_venta, :p_fecha_venta);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Vincular los parámetros
        oci_bind_by_name($stmt, ":p_id_venta", $id_venta);
        oci_bind_by_name($stmt, ":p_id_afiliado", $id_afiliado);
        oci_bind_by_name($stmt, ":p_total_venta", $total_venta);
        oci_bind_by_name($stmt, ":p_fecha_venta", $fecha_venta);

        // Ejecutar el procedimiento
        oci_execute($stmt);

        // Mostrar mensaje de éxito
        echo "<p>Venta creada con éxito.</p>";

    } catch (Exception $e) {
        error_log("Error al crear venta: " . $e->getMessage());
        $error = "Ocurrió un error al crear la venta. Intenta de nuevo más tarde.";
        echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Venta</title>
    <link rel="stylesheet" href="../public/css/formulario.css">
</head>
<body>
    <div class="container">
        <h1>Crear Venta</h1>
        <form method="POST" action="crear_venta.php">
            <label for="id_venta">ID de la venta:</label>
            <input type="number" name="id_venta" required>

            <label for="id_afiliado">ID del afiliado:</label>
            <input type="number" name="id_afiliado" required>

            <label for="total_venta">Total de la venta:</label>
            <input type="number" name="total_venta" step="0.01" required>

            <label for="fecha_venta">Fecha de la venta:</label>
            <input type="date" name="fecha_venta" required>

            <button type="submit">Crear Venta</button>
        </form>
    </div>
</body>
</html>
