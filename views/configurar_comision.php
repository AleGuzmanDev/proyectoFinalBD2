<?php
include("../config/database.php"); // Asegúrate de que la conexión esté configurada correctamente

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $nivel = $_POST['nivel'];
    $porcentaje_comision = $_POST['porcentaje_comision'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Preparar la llamada al procedimiento
        $sql = "BEGIN 
                    crear_configuracion_comision(:p_nivel, :p_porcentaje_comision, :p_id_configuracion);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Variables para los parámetros
        $id_configuracion = null;

        // Vincular los parámetros
        oci_bind_by_name($stmt, ":p_nivel", $nivel);
        oci_bind_by_name($stmt, ":p_porcentaje_comision", $porcentaje_comision);
        oci_bind_by_name($stmt, ":p_id_configuracion", $id_configuracion, 32);

        // Ejecutar la función
        oci_execute($stmt);

        // Verificar si la configuración fue creada exitosamente
        if ($id_configuracion) {
            echo "<p>Configuración de comisión creada con éxito. ID de configuración: " . htmlspecialchars($id_configuracion) . "</p>";
        } else {
            echo "<p>Error al crear la configuración de comisión.</p>";
        }
    } catch (Exception $e) {
        error_log("Error al crear configuración de comisión: " . $e->getMessage());
        $error = "Ocurrió un error al crear la configuración de comisión. Intenta de nuevo más tarde.";
        echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Configuración de Comisión</title>
    <link rel="stylesheet" href="../public/css/formulario.css">
</head>
<body>
    <div class="container">
        <h1>Crear Configuración de Comisión</h1>
        <form method="POST" action="crear_configuracion_comision.php">
            <label for="nivel">Nivel:</label>
            <input type="number" name="nivel" required>
            
            <label for="porcentaje_comision">Porcentaje de Comisión:</label>
            <input type="number" step="0.01" name="porcentaje_comision" required>
            
            <button type="submit">Crear Configuración</button>
        </form>
    </div>
</body>
</html>
