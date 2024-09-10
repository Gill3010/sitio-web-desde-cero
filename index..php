<?php
session_start();
require 'config.php';

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = ''; // Definir la variable para mensajes

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($conn->real_escape_string($_POST['username']));
    $email = trim($conn->real_escape_string($_POST['email']));
    $password = trim($conn->real_escape_string($_POST['password']));

    // Validar nombre de usuario (permitir letras y números, longitud mínima 3)
    if (!preg_match('/^[a-zA-Z0-9]{3,}$/', $username)) {
        $message = "El nombre de usuario debe contener solo letras y números, y al menos 3 caracteres.";
    }
    // Validar correo electrónico
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Correo electrónico no válido.";
    }
    // Validar contraseña (permitir letras, números, y longitud mínima 6)
    elseif (strlen($password) < 6) {
        $message = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        // Verificar si el usuario ya existe
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "El nombre de usuario ya está en uso.";
        } else {
            // Hashear la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertar nuevo usuario
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sss', $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $message = "Registro exitoso";
            } else {
                $message = "Error: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #00c6ff, #0072ff); /* Degradado de color */
            font-family: Arial, sans-serif; /* Fuente por defecto */
        }

        .form-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 30px;
            width: 90%;
            max-width: 400px;
            margin: 20px;
            text-align: center;
        }

        .form-header img {
            height: 65px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            max-width: 300px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .success {
            color: #5bc0de;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .login-link {
            margin-top: 15px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (min-width: 768px) {
            .form-container {
                padding: 40px;
                width: 80%;
                max-width: 500px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <form action="" method="post">
            <div class="form-header">
                <a href="Index.html">
                    <img src="img/logo30.png" alt="Logo">
                </a>
            </div>

            <h2>Crea tu Cuenta</h2>
            <?php if ($message): ?>
                <div class="<?php echo strpos($message, 'exitoso') !== false ? 'success' : 'message'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
<!-- 
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Regístrate Ahora</button> -->

            <div class="login-link">
                <p>¿Ya tienes una cuenta? <a href="index2.php">Inicia sesión aquí</a></p>
            </div>
        </form>
    </div>
</body>
</html>