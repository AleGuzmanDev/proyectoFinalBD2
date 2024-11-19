<?php
include("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $cedula = $_POST['cedula'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $fecha_afiliacion = date('Y-m-d'); // Generar fecha actual
    $estado = 'Activo'; // Estado predeterminado
    $nivel_hierarquia = $_POST['nivel'];
    $afiliado_superior_id = $_POST['reclutador'];

    try {
        $sql = "BEGIN :resultado := crear_afiliado(:nombre, :cedula, :email, :telefono, :direccion,:estado, :nivel_hierarquia, :afiliado_superior_id); END;";
        $stmt = oci_parse($conn, $sql);

        oci_bind_by_name($stmt, ':resultado', $resultado, 32);
        oci_bind_by_name($stmt, ':nombre', $nombre);
        oci_bind_by_name($stmt, ':cedula', $cedula);
        oci_bind_by_name($stmt, ':email', $email);
        oci_bind_by_name($stmt, ':telefono', $telefono);
        oci_bind_by_name($stmt, ':direccion', $direccion);
        oci_bind_by_name($stmt, ':estado', $estado);
        oci_bind_by_name($stmt, ':nivel_hierarquia', $nivel_hierarquia);
        oci_bind_by_name($stmt, ':afiliado_superior_id', $afiliado_superior_id);

        oci_execute($stmt);

        if ($resultado == 1) {
            $msj =  "Afiliado creado exitosamente.";
        } elseif ($resultado == 0) {
            $msj =   "Error: El correo electrónico ya está registrado.";
        } else {
            $msj =   "Error inesperado al crear el afiliado.";
        }
    } catch (Exception $e) {
        echo "Ocurrió un error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MM Enterprise - Afiliaciones</title>
    <link rel="stylesheet" href="../public/css/afiliaciones.css">
</head>
<body>
    <div class="container">
        <!-- Mensaje de error, si existe -->
        <?php if (isset($msj)): ?>
            <p class="error-message"><?= htmlspecialchars($msj) ?></p>
        <?php endif; ?>
        <div class="header">
            <img src="logo.png" alt="MM Enterprise" class="logo">
            <h1 class="title">Afiliaciones</h1>
        </div>

        <form method="POST" action="afiliaciones.php">
            <div class="form-grid">
                <div class="form-group">
                    <label for="cedula">Cédula</label>
                    <input type="text" id="cedula" name="cedula" placeholder="Cédula" required>
                </div>

                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" placeholder="Correo electrónico" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" id="telefono" name="telefono" placeholder="Teléfono">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" id="direccion" name="direccion" placeholder="Dirección">
                </div>

                <div class="form-group">
                    <label for="nivel">Nivel en la red</label>
                    <input type="number" id="nivel" name="nivel" placeholder="Nivel en la red">
                </div>

                <div class="form-group">
                    <label for="reclutador">Id Reclutador</label>
                    <input type="text" id="reclutador" name="reclutador" placeholder="Reclutador">
                </div>
            </div>

            <div class="button-container">
                <button type="button" class="button button-decline"><a href="bienvenido.php">Regresar</a></button>
                <button type="reset" class="button button-decline">Limpiar</button>
                <button type="submit" class="button button-approve">Afiliar</button>
            </div>
        </form>
    </div>
</body>
</html>
