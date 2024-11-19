<?php
include("../config/database.php"); // Archivo con la configuración de conexión a la base de datos

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Llamar al procedimiento PL/SQL
        $sql = "BEGIN 
                    crear_producto(:p_id_producto, :p_nombre_producto, :p_categoria, :p_precio, :p_stock);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Vincular los parámetros con las variables de PHP
        oci_bind_by_name($stmt, ":p_id_producto", $id_producto);
        oci_bind_by_name($stmt, ":p_nombre_producto", $nombre_producto);
        oci_bind_by_name($stmt, ":p_categoria", $categoria);
        oci_bind_by_name($stmt, ":p_precio", $precio);
        oci_bind_by_name($stmt, ":p_stock", $stock);

        // Ejecutar el procedimiento
        oci_execute($stmt);

        // Confirmar al usuario
        echo "<p>Producto creado con éxito.</p>";

    } catch (Exception $e) {
        error_log("Error al crear producto: " . $e->getMessage());
        echo "<p>Error al crear el producto. Por favor, intenta de nuevo.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario
    $id_producto = $_POST['id_producto'];
    $nombre_producto = $_POST['nombre_producto'];
    $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : null;
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Llamar al procedimiento PL/SQL
        $sql = "BEGIN 
                    crear_producto(:p_id_producto, :p_nombre_producto, :p_categoria, :p_precio, :p_stock);
                END;";

        $stmt = oci_parse($conn, $sql);

        // Vincular los parámetros con las variables de PHP
        oci_bind_by_name($stmt, ":p_id_producto", $id_producto);
        oci_bind_by_name($stmt, ":p_nombre_producto", $nombre_producto);
        oci_bind_by_name($stmt, ":p_categoria", $categoria);
        oci_bind_by_name($stmt, ":p_precio", $precio);
        oci_bind_by_name($stmt, ":p_stock", $stock);

        // Ejecutar el procedimiento
        oci_execute($stmt);

        // Confirmar al usuario
        echo ' <div class="alert alert-success" role="alert">
            Producto creado con exito
        </div>';

    } catch (Exception $e) {
        error_log("Error al crear producto: " . $e->getMessage());
        echo "<p>Error al crear el producto. Por favor, intenta de nuevo.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Enterprise - Gestión de Productos</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: rgb(182, 198, 238);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .title {
            text-align: center;
            font-size: 24px;
            color: #333;
            font-style: italic;
            margin-bottom: 30px;
        }

        .content-wrapper {
            display: flex;
            gap: 30px;
            justify-content: space-between;
            align-items: flex-start;
        }

        .form-section {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            text-align: center;
        }

        .button-container {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
            position: relative;
        }

        .button {
            padding: 10px;
            border: none;
            border-radius: 20px;
            background-color: rgb(182, 198, 238);
            color: #333;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .button:hover {
            background-color: rgb(162, 178, 218);
        }

        .delete-icon {
            position: absolute;
            right: -40px;
            bottom: 10px;
            width: 30px;
            height: 30px;
        }

        .products-table {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex-grow: 1;
        }

        .products-table h2 {
            margin-bottom: 15px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid rgb(182, 198, 238);
            text-align: left;
        }

        th {
            background-color: rgb(182, 198, 238);
            color: #333;
            font-weight: bold;
        }

        .product-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="title">Gestión de productos</h1>

        <!-- Ícono de producto -->
        <svg class="product-icon" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <rect x="20" y="40" width="60" height="40" fill="none" stroke="#333" stroke-width="3"/>
            <path d="M30 40 L50 20 L70 40" fill="none" stroke="#333" stroke-width="3"/>
            <circle cx="60" cy="50" r="8" fill="none" stroke="#333" stroke-width="3"/>
            <line x1="60" y1="46" x2="60" y2="54" stroke="#333" stroke-width="3"/>
        </svg>

        <div class="content-wrapper">
            <section class="form-section">
            <form method="POST" action="productos.php">
                <div class="form-group">
                    <input type="text" name="nombre_producto" placeholder="Nombre Producto" required>
                </div>
                <div class="form-group">
                    <input type="text" name="id_producto" placeholder="Id Producto" required>
                </div>
                <div class="form-group">
                    <input type="text" name="categoria" placeholder="Categoria">
                </div>
                <div class="form-group">
                    <input type="number" name="precio" placeholder="Valor unitario" step="0.01" required>
                </div>
                <div class="form-group">
                    <input type="number" name="stock" placeholder="Stock" required>
                </div>
                <div class="button-container">
                    <button type="submit" class="button">Agregar</button>
                </div>
            </form>
            </section>
            <section class="products-table">
                <h2>Productos</h2>
                <?php
                try {
                    if (!$conn) {
                        die("Error al conectar con la base de datos.");
                    }

                    // Preparar la llamada al procedimiento
                    $sql = "BEGIN obtener_productos(:cursor); END;";
                    $stmt = oci_parse($conn, $sql);

                    // Declarar un cursor como parámetro de salida
                    $cursor = oci_new_cursor($conn);
                    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

                    // Ejecutar el procedimiento
                    oci_execute($stmt);

                    // Ejecutar el cursor
                    oci_execute($cursor);

                    // Generar la tabla HTML
                    echo "<table border='1'>";
                    echo "<tr>
                            <th>ID Producto</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Precio</th>
                            <th>Stock</th>
                        </tr>";

                    // Recorrer los datos del cursor
                    while (($row = oci_fetch_assoc($cursor)) != false) {
                        echo "<tr>
                                <td>{$row['ID_PRODUCTO']}</td>
                                <td>{$row['NOMBRE']}</td>
                                <td>{$row['CATEGORIA']}</td>
                                <td>{$row['PRECIO']}</td>
                                <td>{$row['STOCK']}</td>
                            </tr>";
                    }

                    echo "</table>";

                    // Cerrar cursor y liberar recursos
                    oci_free_statement($stmt);
                    oci_free_statement($cursor);
                    oci_close($conn);

                } catch (Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
                ?>

            </section>
        </div>
    </div>
</body>
</html>