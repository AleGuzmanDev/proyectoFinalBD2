<?php
include("../config/database.php"); // Asegúrate de que la conexión esté configurada correctamente

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $id_venta = $_POST['id_venta'];
    $id_afiliado = $_POST['id_afiliado'];
    $nivel_hierarquia = $_POST['nivel_hierarquia'];
    $monto_comision = $_POST['monto_comision'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Preparar la llamada al procedimiento
        $sql = "BEGIN 
                    crear_comision(:p_id_venta, :p_id_afiliado, :p_nivel_hierarquia, :p_monto_comision, :p_id_comision);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Variables para los parámetros
        $id_comision = null;

        // Vincular los parámetros
        oci_bind_by_name($stmt, ":p_id_venta", $id_venta);
        oci_bind_by_name($stmt, ":p_id_afiliado", $id_afiliado);
        oci_bind_by_name($stmt, ":p_nivel_hierarquia", $nivel_hierarquia);
        oci_bind_by_name($stmt, ":p_monto_comision", $monto_comision);
        oci_bind_by_name($stmt, ":p_id_comision", $id_comision, 32);

        // Ejecutar la función
        oci_execute($stmt);

        // Verificar si la comisión fue creada exitosamente
        if ($id_comision) {
            echo "<p>Comisión creada con éxito. ID de la comisión: " . htmlspecialchars($id_comision) . "</p>";
        } else {
            echo "<p>Error al crear la comisión.</p>";
        }
    } catch (Exception $e) {
        error_log("Error al crear comisión: " . $e->getMessage());
        $error = "Ocurrió un error al crear la comisión. Intenta de nuevo más tarde.";
        echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Comisión</title>
    <link rel="stylesheet" href="../public/css/formulario.css">
</head>
<body>
    <div class="container">
        <h1>Crear Comisión</h1>
        <form method="POST" action="crear_comision.php">
            <label for="id_venta">ID Venta:</label>
            <input type="number" name="id_venta" required>
            
            <label for="id_afiliado">ID Afiliado:</label>
            <input type="number" name="id_afiliado" required>
            
            <label for="nivel_hierarquia">Nivel en la jerarquía:</label>
            <input type="number" name="nivel_hierarquia" required>
            
            <label for="monto_comision">Monto Comisión:</label>
            <input type="number" step="0.01" name="monto_comision" required>
            
            <button type="submit">Crear Comisión</button>
        </form>
    </div>
</body>
</html>
