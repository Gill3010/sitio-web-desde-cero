<?php
session_start();
require 'config.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    echo 'error: Usuario no autenticado'; // Usuario no autenticado
    exit();
}

// Verificar si se ha enviado un ID para eliminar
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Asegúrate de que el ID es un número entero
    $user_id = $_SESSION['user_id']; // ID del usuario autenticado

    // Preparar y ejecutar la consulta para verificar el propietario
    $stmt = $conn->prepare("SELECT user_id FROM sponsor_registros WHERE id = ?");
    if ($stmt === false) {
        echo 'error: ' . $conn->error; // Error en la preparación de la consulta
        exit();
    }

    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($owner_id);
    $stmt->fetch();
    $stmt->close();

    // Verificar si el usuario es el propietario del registro
    if ($owner_id !== $user_id) {
        echo 'error: Usuario no autorizado'; // El usuario no es el propietario del registro
        exit();
    }

    // Preparar y ejecutar la consulta de eliminación
    $stmt = $conn->prepare("DELETE FROM sponsor_registros WHERE id = ?");
    if ($stmt === false) {
        echo 'error: ' . $conn->error; // Error en la preparación de la consulta
        exit();
    }

    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        echo 'success'; // Enviar respuesta de éxito
    } else {
        echo 'error: ' . $stmt->error; // Enviar respuesta de error con detalles
    }

    $stmt->close();
} else {
    echo 'error: ID no proporcionado'; // Enviar respuesta de error si no se ha enviado un ID
}

$conn->close();
?>