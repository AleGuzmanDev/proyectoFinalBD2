<?php
// Configuración de la conexión
$host = 'localhost';      // Cambia según la dirección del servidor
$port = '1521';           // Puerto predeterminado de Oracle
$sid = 'xe';              // Nombre del servicio (SID)
$username = 'ANDERSONFONSECA';  // Usuario de la base de datos
$password = '123456';       // Contraseña

// String de conexión
$connectionString = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)))";


// Especificar la codificación UTF-8
putenv('NLS_LANG=AMERICAN_AMERICA.AL32UTF8');

$conn = oci_connect($username, $password,  'localhost/XE');


try {
    // Establecer la conexión

    if (!$conn) {
        throw new Exception(oci_error());
    }

    // Mensaje opcional de éxito
    echo "Conexión exitosa a la base de datos Oracle.";

    // Código adicional para interactuar con la base de datos...
} catch (Exception $e) {
    // Manejo de errores
    echo "Error al conectar con Oracle: " . $e->getMessage();
    error_log("Error de conexión: " . $e->getMessage()); // Registro de errores
    exit;
} finally {
    // Liberar recursos
    if ($conn) {
        oci_close($conn);
    }
}
?>
