<?php
// Configuración de conexión a la base de datos
include("../config/database.php");

if (!$conn) {
    $e = oci_error();
    echo "Error al conectar: " . $e['message'];
    exit;
}

// Verificar si se ha pasado un ID_INVENTARIO para eliminar
if (isset($_GET['id'])) {
    $id_inventario = $_GET['id'];

    // Preparar la llamada al procedimiento para eliminar el inventario
    $sql = "BEGIN ELIMINAR_INVENTARIO(:id_inventario); END;";
    $stmt = oci_parse($conn, $sql);

    // Vincular el parámetro del procedimiento
    oci_bind_by_name($stmt, ":id_inventario", $id_inventario, -1, SQLT_INT);

    // Ejecutar el procedimiento
    if (!oci_execute($stmt)) {
        $e = oci_error($stmt);
        echo "Error al ejecutar el procedimiento: " . $e['message'];
        exit;
    } else {
        echo "<script>alert('Inventario eliminado exitosamente'); window.location='inventario_show.php';</script>";
    }
}

// Preparar la llamada al procedimiento para mostrar inventario
$sql = "BEGIN MOSTRAR_INVENTARIO(:cursor); END;";
$stmt = oci_parse($conn, $sql);

// Crear el cursor
$cursor = oci_new_cursor($conn);

// Vincular el cursor como parámetro de salida
oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

// Ejecutar el procedimiento
if (!oci_execute($stmt)) {
    $e = oci_error($stmt);
    echo "Error al ejecutar el procedimiento: " . $e['message'];
    exit;
}

// Ejecutar el cursor
oci_execute($cursor);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-primary">Inventario de Productos</h1>

        <div class="mb-3">
            <!-- Botones para agregar, editar y eliminar -->
            <a href="agregar_inventario.php" class="btn btn-success">Agregar Inventario</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID Inventario</th>
                    <th>ID Producto</th>
                    <th>Stock</th>
                    <th>Fecha de Ingreso</th>
                    <th>Fecha de Salida</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = oci_fetch_assoc($cursor)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID_INVENTARIO']) ?></td>
                        <td><?= htmlspecialchars($row['ID_PRODUCTO']) ?></td>
                        <td><?= htmlspecialchars($row['STOCK']) ?></td>
                        <td><?= htmlspecialchars($row['FECHA_INGRESO']) ?></td>
                        <td><?= htmlspecialchars($row['FECHA_SALIDA']) ?></td>
                        <td>
                            <!-- Botón para eliminar inventario -->
                            <a href="inventario_show.php?id=<?= htmlspecialchars($row['ID_INVENTARIO']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este inventario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Liberar recursos
oci_free_statement($stmt);
oci_free_statement($cursor);
oci_close($conn);
?>
