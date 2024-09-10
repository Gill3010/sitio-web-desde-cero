<?php 
session_start();
require 'config.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index2.php");
    exit;
}

// Obtiene el user_id de la sesión
$user_id = $_SESSION['user_id'];
if (!$user_id) {
    die('User ID no está configurado en la sesión.');
}

// Obtener la información del perfil actual
$sql = "SELECT channel_name, description, profile_picture, cover_photo FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($channel_name, $description, $profile_picture, $cover_photo);
    $stmt->fetch();
} else {
    header("Location: index.php");
    exit;
    die('No se encontró el perfil del usuario.');
}
$stmt->close();

// Procesa el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $channel_name = htmlspecialchars($_POST['channel_name']);
    $description = htmlspecialchars($_POST['description']);

    // Manejo de la imagen de perfil
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $profile_picture = 'uploads/' . basename($_FILES['profile_picture']['name']);
        if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_picture)) {
            echo "Error al mover el archivo de perfil: " . $_FILES['profile_picture']['error'];
        }
    } else {
        $profile_picture = null; // No se subió ninguna nueva imagen
    }

    // Manejo de la foto de portada
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] == 0) {
        $cover_photo = 'uploads/' . basename($_FILES['cover_photo']['name']);
        if (!move_uploaded_file($_FILES['cover_photo']['tmp_name'], $cover_photo)) {
            echo "Error al mover el archivo de portada: " . $_FILES['cover_photo']['error'];
        }
    } else {
        $cover_photo = null; // No se subió ninguna nueva imagen
    }

    // Construye la consulta SQL de actualización
    $sql = "UPDATE profiles SET channel_name = ?, description = ?";
    $params = [$channel_name, $description];

    if ($profile_picture) {
        $sql .= ", profile_picture = ?";
        $params[] = $profile_picture;
    }

    if ($cover_photo) {
        $sql .= ", cover_photo = ?";
        $params[] = $cover_photo;
    }

    $sql .= " WHERE user_id = ?";
    $params[] = $user_id;

    $stmt = $conn->prepare($sql);
    
    // Genera dinámicamente los tipos de parámetros
    $types = str_repeat('s', count($params) - 1) . 'i'; // 's' para cadenas, 'i' para enteros
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        header("Location: viewprofile.php?success=true");
        exit;
    } else {
        echo "Error al actualizar el perfil: " . $stmt->error;
    }
    
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
    <link rel="stylesheet" href="styles.css">
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
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
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
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        img {
            margin: 10px 0;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true') { ?>
            <div class="success">Perfil actualizado con éxito.</div>
        <?php } ?>

        <div class="form-header">
    <a href="/Index.html"> <!-- Reemplaza con la URL a la que quieres enlazar -->
        <img src="/img/logo30.png" alt="Logo">
    </a>
</div>
        <h2>Editar Perfil</h2>

        <form action="" method="post" enctype="multipart/form-data" id="editProfileForm">
            <label for="channel_name">Nombre del Canal:</label>
            <input type="text" id="channel_name" name="channel_name" value="<?php echo htmlspecialchars($channel_name); ?>" required>
            
            <label for="description">Descripción:</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($description); ?></textarea>
            
            <label for="profile_picture">Foto de Perfil:</label>
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
            <?php if ($profile_picture): ?>
                <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Foto de Perfil Actual" width="100">
            <?php endif; ?>

            <label for="cover_photo">Foto de Portada:</label>
            <input type="file" id="cover_photo" name="cover_photo" accept="image/*">
            <?php if ($cover_photo): ?>
                <img src="<?php echo htmlspecialchars($cover_photo); ?>" alt="Foto de Portada Actual" width="100">
            <?php endif; ?>

            <button type="submit" id="submit-button">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>