<?php
session_start();
require 'config.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index2.php");
    exit;
    die("Error: Sesión no válida.");
}

// Obtén el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Obtén los datos del perfil del usuario
$sql = "SELECT channel_name, description, profile_picture, cover_photo, unique_url FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($channel_name, $description, $profile_picture, $cover_photo, $unique_url);
    $stmt->fetch();
} else {
     header("Location: index.php");
    exit;
    die("No se encontró el perfil del usuario.");
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        .form-header img {
            height: 65px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        h1 {
            color: #333;
            margin-bottom: 10px;
        }
        .profile-img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .cover-photo {
    width: 100%;
    height: 100%; /* Ocupa toda la altura del contenedor */
    object-fit: contain; /* Ajusta la imagen para que se muestre completa */
    object-position: center; /* Centra la imagen dentro del contenedor */
    margin-bottom: 20px;
    display: block; /* Asegura que la imagen sea un bloque para evitar espacios inesperados */
}
        .content p {
            font-size: 16px;
            margin: 0;
        }
        .profile-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 16px;
            color: #007bff;
            text-decoration: none;
        }
        .profile-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            <div class="success">Perfil creado/actualizado con éxito.</div>
        <?php } ?>
        <div class="form-header">
            <a href="Index.html">
                <img src="img/logo30.png" alt="Logo">
            </a>
        </div>
        <div class="content">
            <h1><?php echo htmlspecialchars($channel_name); ?></h1>

            <?php
            // Ruta a la imagen de portada predeterminada
            $default_cover_photo = 'img/Encuentro.jpeg';

            // Mostrar la imagen de portada predeterminada
            ?>
            <img src="<?php echo htmlspecialchars($default_cover_photo); ?>" alt="Portada" class="cover-photo">

            <?php if ($profile_picture) { ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Perfil" class="profile-img">
            <?php } ?>

            <p><?php echo htmlspecialchars($description); ?></p>

            <a href="<?php echo htmlspecialchars($unique_url); ?>" class="profile-link">Agregar Ficheros</a>
        </div>
    </div>
</body>
</html>