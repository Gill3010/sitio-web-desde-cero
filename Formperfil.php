<?php 
session_start();
require 'config.php';

// Habilita el reporte de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
     header("Location: index2.php");
    exit;
    die("Error: Sesión no válida.");
}

// Verifica si las variables de sesión están definidas
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    die("Error: Sesión no válida.");
}

// Procesa el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanea y obtiene los datos del formulario
    $channel_name = htmlspecialchars($_POST['channel_name']);
    $description = htmlspecialchars($_POST['description']);

    // Manejo de la imagen de perfil
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture)) {
            echo "Error al mover el archivo de perfil: " . $_FILES['profile_picture']['error'];
            $profile_picture = null; // Maneja el error si no se mueve el archivo
        }
    } else {
        $profile_picture = null;
    }

    // Manejo de la foto de portada
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] == 0) {
        $cover_photo = 'uploads/' . basename($_FILES['cover_photo']['name']);
        if (!move_uploaded_file($_FILES['cover_photo']['tmp_name'], $cover_photo)) {
            echo "Error al mover el archivo de portada: " . $_FILES['cover_photo']['error'];
            $cover_photo = null; // Maneja el error si no se mueve el archivo
        }
    } else {
        $cover_photo = null;
    }

    // Genera una URL única para el perfil
    $username = $_SESSION['username'];
    $unique_url = 'https://www.galeria-virtual.org/sponsor/' . urlencode($username);

    // Guarda los datos en la base de datos, incluyendo la URL única
    $stmt = $conn->prepare("INSERT INTO profiles (user_id, channel_name, description, profile_picture, cover_photo, unique_url) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Asegúrate de que las variables coincidan con los tipos esperados
    $user_id = $_SESSION['user_id']; // Usar 'user_id' en lugar de 'id'
    $stmt->bind_param("isssss", $user_id, $channel_name, $description, $profile_picture, $cover_photo, $unique_url);
    
    if (!$stmt->execute()) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
    
    $stmt->close();

    // Redirige a una página de éxito
    header("Location: viewprofile.php?success=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Creación de Perfil</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
 
    <style>
        .form-header img {
            height: 65px;
            margin-right: 30px;
        }

        .form-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px; /* Ajusta el ancho máximo si es necesario */
            margin: 0 auto;
            text-align: center;
        }

        .form-header {
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        h3 {
            margin-bottom: 15px;
            color: #555;
        }

        label {
            display: block;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        textarea,
        input[type="file"] {
            width: 100%;
            max-width: 400px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            margin-bottom: 15px;
            box-sizing: border-box; /* Asegura que el padding no afecte el tamaño total */
        }

        button {
            background-color: #ffb606;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            max-width: 400px;
        }

        button:hover {
            background-color: #00008b;
        }

        .success 
        /* Ocultar el input de archivos */
#cover_photo {
  display: none;
}
    </style>
</head>
<body>
    <div class="form-container">
        <?php if (isset($_GET['success'])) { echo '<div class="success">Perfil creado con éxito.</div>'; } ?>
        
        <form action="" method="post" enctype="multipart/form-data" id="profileForm">
            <div class="form-header">
                <a href="Index.html">
                    <img src="img/logo30.png" alt="Logo">
                </a>
            </div>
            <h2>Creación de Perfil</h2>

            <h3>Información del Perfil</h3>

            <label for="channel_name">Nombre del Evento:</label>
            <input type="text" id="channel_name" name="channel_name" required>
            
            <label for="description">Descripción:</label>
            <textarea id="description" name="description"></textarea>
            
            <label for="profile_picture">Foto de Perfil:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            
            <!-- Mostrar la imagen de portada fija -->
<label for="cover_photo">Foto de Portada:</label>
<img id="cover_image" src="img/Encuentro.jpeg" alt="Foto de Portada" width="300">

            <button type="submit" id="submit-button">Crear Perfil</button>
        </form>
    </div>
</body>
</html>