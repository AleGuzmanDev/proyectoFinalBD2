<?php
include("../config/database.php"); // Asegúrate de que la conexión esté configurada correctamente

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Preparar la llamada al procedimiento
        $sql = "BEGIN 
                    crear_producto(:p_id_producto, :p_nombre, :p_categoria, :p_precio, :p_stock);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Vincular los parámetros
        oci_bind_by_name($stmt, ":p_id_producto", $id_producto);
        oci_bind_by_name($stmt, ":p_nombre", $nombre);
        oci_bind_by_name($stmt, ":p_categoria", $categoria);
        oci_bind_by_name($stmt, ":p_precio", $precio);
        oci_bind_by_name($stmt, ":p_stock", $stock);

        // Ejecutar el procedimiento
        oci_execute($stmt);

        // Mostrar mensaje de éxito
        echo "<p>Producto creado con éxito.</p>";

    } catch (Exception $e) {
        error_log("Error al crear producto: " . $e->getMessage());
        $error = "Ocurrió un error al crear el producto. Intenta de nuevo más tarde.";
        echo "<p class='error-message'>" . htmlspecialchars($error) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Producto</title>
    <link rel="stylesheet" href="../public/css/formulario.css">
</head>
<body>
    <div class="container">
        <h1>Crear Producto</h1>
        <form method="POST" action="crear_producto.php">
            <label for="id_producto">ID del producto:</label>
            <input type="number" name="id_producto" required>

            <label for="nombre">Nombre del producto:</label>
            <input type="text" name="nombre" required>

            <label for="categoria">Categoría:</label>
            <input type="text" name="categoria">

            <label for="precio">Precio:</label>
            <input type="number" name="precio" step="0.01" required>

            <label for="stock">Stock:</label>
            <input type="number" name="stock" required>

            <button type="submit">Crear Producto</button>
        </form>
    </div>
</body>
</html>
