<?php
// Iniciamos sesión para poder guardar los datos
session_start();

$mensaje = "";
$clase_alerta = "";

// Comprobamos si el usuario dio clic en el botón de registrar
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_completo = trim($_POST['nombre_completo']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validaciones
    if (empty($nombre_completo) || empty($username) || empty($password) || empty($confirm_password)) {
        $mensaje = "Todos los campos son obligatorios.";
        $clase_alerta = "alert-danger";
    } elseif (strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
        $clase_alerta = "alert-danger";
    } elseif ($password !== $confirm_password) {
        $mensaje = "La contraseña y su confirmación no coinciden.";
        $clase_alerta = "alert-danger";
    } else {
        
        // Encriptamos la contraseña
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Guardamos el usuario con su contraseña 
        $_SESSION['usuario_registrado'] = [
            'nombre' => $nombre_completo,
            'login' => $username,
            'hash' => $password_encriptada // Guardamos el hash, no el texto plano
        ];

        $mensaje = "Usuario registrado correctamente";
        $clase_alerta = "alert-success";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleados</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <img src="https://picsum.photos" alt="Icono de Registro" class="banner-img">
    <h2>Registro de Personal</h2>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert <?php echo $clase_alerta; ?>">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>

    <form action="registro.php" method="POST">
        <div class="form-group">
            <label>Nombre Completo:</label>
            <input type="text" name="nombre_completo" required>
        </div>
        <div class="form-group">
            <label>Nombre de Usuario (Login):</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <div class="form-group">
            <label>Confirmar Contraseña:</label>
            <input type="password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn">Registrar Usuario</button>
    </form>
    <a href="login.php" class="switch-link">¿Ya tienes cuenta? Inicia sesión aquí</a>
</div>
</body>
</html>
