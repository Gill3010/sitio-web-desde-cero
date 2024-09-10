<?php
session_start();
require 'config.php'; // Conexión a la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    die('Error: Sesión no válida.');
}

// Procesa la subida de archivos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Manejo del archivo subido
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file = 'uploads/' . basename($_FILES['file']['name']);
        
        // Mueve el archivo al directorio de subida
        if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
            // Prepara la consulta SQL para insertar la información del archivo en la base de datos
            $stmt = $conn->prepare("INSERT INTO user_files (user_id, file_path) VALUES (?, ?)");
            if ($stmt === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            // Vincula el user_id de la sesión y la ruta del archivo
            $stmt->bind_param("is", $_SESSION['user_id'], $file);
            if (!$stmt->execute()) {
                die('Execute failed: ' . htmlspecialchars($stmt->error));
            }
            $stmt->close();
            
            echo 'Archivo subido con éxito.';
        } else {
            echo 'Error al mover el archivo.';
        }
    } else {
        echo 'No se seleccionó ningún archivo o hubo un error en la subida.';
    }
}
?>