<?php
// api.php

// Supongamos que ya tienes conexión a la base de datos y funciones configuradas
include_once 'db_connection.php';
include_once 'functions.php';

// Obtener la ruta solicitada
$requestUri = $_SERVER['REQUEST_URI'];

// Verificar si la solicitud es para el endpoint de usuario
if (preg_match('/^\/api\/user\/(.+)$/', $requestUri, $matches)) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $username = $matches[1]; // Obtiene el username de la URL
        // Consultar la base de datos por el usuario
        $userInfo = getUserInfoByUsername($username);

        if ($userInfo) {
            echo json_encode($userInfo);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Usuario no encontrado']);
        }
    }
} else {
    // Manejar otras rutas o devolver un 404 si la ruta no existe
    http_response_code(404);
    echo json_encode(['message' => 'Endpoint no encontrado']);
}