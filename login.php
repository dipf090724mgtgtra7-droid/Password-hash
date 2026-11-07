<?php
// Iniciar sesión para acceder al arreglo de usuarios registrados
session_start();

$mensaje = "";
$tipo_mensaje = "";

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Verificar si el usuario existe 
    if (isset($_SESSION['usuarios'][$username])) {
        // Recuperar el hash de la contraseña guardada
        $hash_guardado = $_SESSION['usuarios'][$username]['hash'];
        $nombre_usuario = $_SESSION['usuarios'][$username]['nombre'];

        // Verificar la contraseña
        if (password_verify($password, $hash_guardado)) {
            $mensaje = "Bienvenido al sistema, " . htmlspecialchars($nombre_usuario);
            $tipo_mensaje = "success";
        } else {
            $mensaje = "Contraseña incorrecta.";
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "El nombre de usuario no existe.";
        $tipo_mensaje = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <!-- Vinculación del archivo CSS externo -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <!-- Imagen-->
        <img src="bloqueo-de-cuenta.png" alt="Login Icono">
        
        <h2>Iniciar Sesión</h2>

        <!-- Mostrar mensajes de acceso o error -->
        <?php if (!empty($mensaje)): ?>
            <div class="message <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Nombre de Usuario:</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
        <p><a href="registro.php">¿No tienes cuenta? Regístrate aquí</a></p>
    </div>
</body>
</html>



