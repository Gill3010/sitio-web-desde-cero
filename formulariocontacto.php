<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre_completo = $_POST['nombre_completo'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];

// Insertar los datos en la tabla 'contactos'
$sql = "INSERT INTO contactos (nombre_completo, correo, telefono) VALUES ('$nombre_completo', '$correo', '$telefono')";

if ($conn->query($sql) === TRUE) {
    echo "Datos guardados exitosamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link rel="stylesheet" href="estilos.css"> <!-- Archivo CSS externo -->
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.contact-form {
    width: 400px;
    margin: 50px auto;
    padding: 30px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.contact-form h2 {
    margin-bottom: 20px;
    color: #333;
}

.contact-form label {
    display: block;
    margin-bottom: 8px;
    color: #666;
}

.contact-form input[type="text"],
.contact-form input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.contact-form input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.contact-form input[type="submit"]:hover {
    background-color: #0056b3;
}
    </style>
</head>
<body>
    <div class="contact-form">
        <h2>Contacto</h2>
        <form action="" method="POST">
            <label for="nombre_completo">Nombre Completo:</label>
            <input type="text" id="nombre_completo" name="nombre_completo" required>

            <label for="correo">Correo Electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="telefono">Número de Teléfono:</label>
            <input type="text" id="telefono" name="telefono" required>

            <input type="submit" value="Enviar">
        </form>
    </div>
</body>
</html>