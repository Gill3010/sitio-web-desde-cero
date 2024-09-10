<?php
session_start();
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cierre de Sesión</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Ajusta la altura al 100% de la pantalla */
            background-color: #f4f4f4; /* Color de fondo de la página */
        }

        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 90%; /* Usar el 90% de la pantalla para móviles */
            max-width: 400px; /* Máximo ancho para pantallas grandes */
            margin: 20px; /* Margen para que no quede pegado a los bordes */
            text-align: center; /* Centrar el texto dentro del formulario */
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .message {
            color: #5bc0de; /* Light blue color for success */
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Has cerrado sesión exitosamente</h2>
        <div class="message">
            <p>Gracias por usar nuestro sistema. Puedes <a href="index2.php">iniciar sesión de nuevo</a> si lo deseas.</p>
        </div>
    </div>
</body>
</html>