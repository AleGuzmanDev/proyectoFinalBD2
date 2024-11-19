<?php
// Configuración de conexión a la base de datos
include("../config/database.php");

if (!$conn) {
    $e = oci_error();
    echo "Error al conectar: " . $e['message'];
    exit;
}

// Preparar la llamada al procedimiento
$sql = "BEGIN MOSTRAR_AFILIADOS(:cursor); END;";
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
    <title>Gestión de Afiliados</title>
    <!-- Agregar Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-primary">Gestión de Afiliados</h1>
            <a href="afiliaciones.php" class="btn btn-success">Realizar Afiliación</a>
        </div>

        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID Afiliado</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Fecha de Afiliación</th>
                    <th>Estado</th>
                    <th>Nivel Jerárquico</th>
                    <th>Afiliado Superior</th>
                    <th>Cédula</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = oci_fetch_assoc($cursor)): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['ID_AFILIADO']) ?></td>
                        <td><?= htmlspecialchars($row['NOMBRE']) ?></td>
                        <td><?= htmlspecialchars($row['EMAIL']) ?></td>
                        <td><?= htmlspecialchars($row['TELEFONO']) ?></td>
                        <td><?= htmlspecialchars($row['DIRECCION']) ?></td>
                        <td><?= htmlspecialchars($row['FECHA_AFILIACION']) ?></td>
                        <td><?= htmlspecialchars($row['ESTADO']) ?></td>
                        <td><?= htmlspecialchars($row['NIVEL_HIERARQUIA']) ?></td>
                        <td><?= htmlspecialchars($row['AFILIADO_SUPERIOR_ID']) ?></td>
                        <td><?= htmlspecialchars($row['CEDULA']) ?></td>
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
