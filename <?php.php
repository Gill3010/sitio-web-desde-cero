<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = htmlspecialchars($_POST['nombres']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $email = htmlspecialchars($_POST['email']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $institucion = htmlspecialchars($_POST['institucion']);
    $pais = htmlspecialchars($_POST['pais']);
    $username = $_SESSION['username'];
    
    // Inicializar variables para almacenar las rutas de las imágenes del perfil
    $profilePicturePath = null;
    $coverPhotoPath = null;

    // Directorios de subida
    $uploads_dir = 'uploads/sponsor';
    $profile_pics_dir = "$uploads_dir/profile_pictures";
    $cover_photos_dir = "$uploads_dir/cover_photos";

    // Asegurarse de que los directorios existen
    if (!is_dir($uploads_dir)) mkdir($uploads_dir, 0777, true);
    if (!is_dir($profile_pics_dir)) mkdir($profile_pics_dir, 0777, true);
    if (!is_dir($cover_photos_dir)) mkdir($cover_photos_dir, 0777, true);

    // Procesar la imagen de perfil
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);
        $profilePicturePath = "$profile_pics_dir/" . uniqid() . '-' . $fileName;
        if (!move_uploaded_file($fileTmpPath, $profilePicturePath)) {
            die('Error al mover la imagen de perfil.');
        }
    }

    // Procesar la foto de portada
    if (isset($_FILES['cover_photo']) && $_FILES['cover_photo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['cover_photo']['tmp_name'];
        $fileName = basename($_FILES['cover_photo']['name']);
        $coverPhotoPath = "$cover_photos_dir/" . uniqid() . '-' . $fileName;
        if (!move_uploaded_file($fileTmpPath, $coverPhotoPath)) {
            die('Error al mover la foto de portada.');
        }
    }

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO sponsor_registros (nombres, apellidos, email, telefono, institucion, pais, profile_picture, cover_photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    // Verifica el tipo de parámetros a pasar en bind_param
    $stmt->bind_param('ssssssss', $nombres, $apellidos, $email, $telefono, $institucion, $pais, $profilePicturePath, $coverPhotoPath);
    $stmt->execute();

    if ($stmt->error) {
        die('Error en la ejecución de la consulta: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    header("Location: perfil_creado.php?success=true");
    exit;
}
?>