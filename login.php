<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container">
    <!-- imagen-->
    <img src="https://picsum.photos" alt="Icono de Login" class="banner-img">
    <h2>Inicio de Sesión</h2>

    <form action="login.php" method="POST">
        <div class="form-group">
            <label>Nombre de Usuario:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Contraseña:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" class="btn">Ingresar</button>
    </form>
    <a href="registro.php" class="switch-link">¿No tienes cuenta? Regístrate aquí</a>
</div>
</body>
</html>
