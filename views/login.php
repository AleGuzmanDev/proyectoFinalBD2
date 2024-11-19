<?php
include("../config/database.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario']);
    $contrasena = $_POST['contrasena'];

    try {
        if (!$conn) {
            die("Error al conectar con la base de datos. Verifique su configuración.");
        }

        // Preparar la llamada a la función
        $sql = "BEGIN :resultado := validar_usuario(:nombre_usuario, :contrasena); END;";
        $stmt = oci_parse($conn, $sql);

        // Variable para capturar el resultado de la función
        $resultado = null;

        // Vincular los parámetros
        oci_bind_by_name($stmt, ':nombre_usuario', $nombre_usuario);
        oci_bind_by_name($stmt, ':contrasena', $contrasena);
        oci_bind_by_name($stmt, ':resultado', $resultado, 32);

        // Ejecutar la función
        oci_execute($stmt);

        // Manejar el resultado
        if ($resultado == 1) {
            $_SESSION['usuario'] = $nombre_usuario;     
            header("Location: bienvenido.php");
            exit;
        } elseif ($resultado == 0) {
            $error = "Usuario o contraseña incorrecta.";
        } else {
            $error = "Error inesperado. Intente más tarde.";
        }
    } catch (Exception $e) {
        error_log("Error al iniciar sesión: " . $e->getMessage());
        $error = "Ocurrió un error. Intenta de nuevo más tarde.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../public/css/login.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="logo.png" alt="Logo" class="logo-img">
                <h2>MM Enterprise</h2>
            </div>
            <h3>Iniciar sesión</h3>
            <form method="POST" action="login.php"> <!-- Aseguramos que se use POST -->
                <input type="text" name="nombre_usuario" placeholder="Nombre de usuario" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
            <br>
            <!-- Mensaje de error, si existe -->
            <?php if (isset($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
