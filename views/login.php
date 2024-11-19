<!-- login.php -->
<?php 
// Incluimos la conexión a la base de datos
include("../config/database.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibimos los datos del formulario
    $nombre_usuario = $_POST['nombre_usuario'];
    $contrasena = $_POST['contrasena'];

    // Verificar las credenciales
    $sql = "SELECT * FROM USUARIO WHERE NOMBRE_USUARIO = :nombre_usuario";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ':nombre_usuario', $nombre_usuario);

    oci_execute($stmt);
    $usuario = oci_fetch_assoc($stmt);

    // Si el usuario existe y la contraseña es correcta
    if ($usuario && password_verify($contrasena, $usuario['CONTRASENA'])) {
        // Crear una sesión
        session_start();
        $_SESSION['usuario_id'] = $usuario['ID_USUARIO'];
        $_SESSION['nombre_usuario'] = $usuario['NOMBRE_USUARIO'];

        // Redirigir a la página principal
        header("Location: index.php");
        exit;
    } else {
        $error = "Nombre de usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../../public/style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="logo">
                <img src="logo.png" alt="Logo" class="logo-img">
                <h2>MM Enterprise</h2>
            </div>
            <h3>Iniciar sesión</h3>
            <form>
                <input type="email" placeholder="Correo electrónico" required>
                <input type="password" placeholder="Contraseña" required>
                <button type="submit">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
