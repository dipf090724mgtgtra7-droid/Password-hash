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
        // Encriptamos la contraseña usando password_hash
        $password_encriptada = password_hash($password, PASSWORD_DEFAULT);

        // Guardamos el usuario protegido en el arreglo de la sesión
        $_SESSION['usuario_registrado'] = [
            'nombre' => $nombre_completo,
            'login' => $username,
            'hash' => $password_encriptada
        ];

        $mensaje = "Usuario registrado correctamente con contraseña encriptada";
        $clase_alerta = "alert-success";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Empleados</title>
    <style>
        /* Estilos Integrados */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #faf2f9;
            color: #333333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            background-color: #f7b4e3;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(221, 102, 221, 0.61);
            width: 100%;
            max-width: 420px;
            text-align: center;
        }
        .banner-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            margin-bottom: 20px;
            border-radius: 50%;
            border: 3px solid #e2b3f5;
            padding: 3px;
            background-color: #fff;
        }
        h2 {
            color: #965196;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #555555;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            font-size: 15px;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            border-color: #00796b;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 121, 107, 0.15);
            outline: none;
        }
        .btn {
            background-color: #00796b;
            color: #ffffff;
            padding: 14px;
            border: none;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #004d40;
        }
        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            text-align: left;
        }
        .alert-success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #4caf50;
        }
        .alert-danger {
            background-color: #ffebee;
            color: #c62828;
            border-left: 4px solid #f44336;
        }
        .switch-link {
            margin-top: 25px;
            display: inline-block;
            color: #00796b;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
        }
        .switch-link:hover {
            text-decoration: underline;
        }
    </style>
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
