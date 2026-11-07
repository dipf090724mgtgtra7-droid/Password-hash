<?php
// Iniciar sesión 
session_start();

// Inicializar el arreglo
if (!isset($_SESSION['usuarios'])) {
    $_SESSION['usuarios'] = [];
}

$mensaje = "";
$tipo_mensaje = "";

// Comprobar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar y limpiar campos
    $nombre = trim($_POST['nombre']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validar que todos los campos sean obligatorios
    if (empty($nombre) || empty($username) || empty($password) || empty($confirm_password)) {
        $mensaje = "Todos los campos son obligatorios.";
        $tipo_mensaje = "error";
    } 
    // Validar longitud 
    elseif (strlen($password) < 6) {
        $mensaje = "La contraseña debe tener al menos 6 caracteres.";
        $tipo_mensaje = "error";
    } 
    // Validar que ambas contraseñas coincidan
    elseif ($password !== $confirm_password) {
        $mensaje = "Las contraseñas no coinciden.";
        $tipo_mensaje = "error";
    } 
    // Validar si el usuario ya existe 
    elseif (isset($_SESSION['usuarios'][$username])) {
        $mensaje = "El nombre de usuario ya está registrado.";
        $tipo_mensaje = "error";
    } 
    else {
        // Encriptar la contraseña usando password_hash
        $password_segura = password_hash($password, PASSWORD_DEFAULT);

        // Guardar el usuario
        $_SESSION['usuarios'][$username] = [
            'nombre' => $nombre,
            'hash' => $password_segura
        ];

        $mensaje = "¡Usuario registrado correctamente!";
        $tipo_mensaje = "success";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuarios</title>
    <!-- Vinculación del archivo CSS externo -->
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="container">
        <!-- Imagen-->
        <img src="registro.png" alt="Registro Icono">
        
        <h2>Registro de Empleados</h2>

        <!-- Mostrar mensajes de éxito o error si existen -->
        <?php if (!empty($mensaje)): ?>
            <div class="message <?php echo $tipo_mensaje; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="registro.php" method="POST">
            <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" required>
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
            <button type="submit">Registrar Usuario</button>
        </form>
        <p><a href="login.php">¿Ya tienes cuenta? Inicia sesión aquí</a></p>
    </div>
</body>
</html>


