<?php
include("../config/database.php");

try {
    if (!$conn) {
        die("Error al conectar con la base de datos.");
    }

    // Preparar la llamada al procedimiento
    $sql = "BEGIN obtener_reporte_por_vendedor(:cursor); END;";
    $stmt = oci_parse($conn, $sql);

    // Declarar un cursor como parámetro de salida
    $cursor = oci_new_cursor($conn);
    oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

    // Ejecutar el procedimiento
    oci_execute($stmt);

    // Ejecutar el cursor
    oci_execute($cursor);

    // Generar la tabla HTML
    echo "<!DOCTYPE html>
          <html lang='es'>
          <head>
              <meta charset='UTF-8'>
              <meta name='viewport' content='width=device-width, initial-scale=1.0'>
              <title>Reporte por Vendedor</title>
              <style>
                  table {
                      border-collapse: collapse;
                      width: 100%;
                      margin: 20px 0;
                  }
                  th, td {
                      border: 1px solid #ddd;
                      padding: 8px;
                      text-align: left;
                  }
                  th {
                      background-color: #f4f4f4;
                      color: #333;
                  }
              </style>
          </head>
          <body>
              <h1>Reporte por Vendedor</h1>
              <table>
                  <thead>
                      <tr>
                          <th>ID Vendedor</th>
                          <th>Nombre</th>
                          <th>Número de Ventas</th>
                          <th>Total Vendido</th>
                      </tr>
                  </thead>
                  <tbody>";

    // Recorrer los datos del cursor
    while (($row = oci_fetch_assoc($cursor)) != false) {
        echo "<tr>
                <td>{$row['ID_AFILIADO']}</td>
                <td>{$row['NOMBRE']}</td>
                <td>{$row['NUMERO_VENTAS']}</td>
                <td>$" . number_format($row['TOTAL_VENTAS'], 2) . "</td>
              </tr>";
    }

    echo "</tbody>
          </table>
          </body>
          </html>";

    // Cerrar cursor y liberar recursos
    oci_free_statement($stmt);
    oci_free_statement($cursor);
    oci_close($conn);

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
