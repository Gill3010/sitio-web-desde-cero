<?php
require 'config.php';
require 'vendor/autoload.php'; // Si usas composer para instalar firebase/php-jwt

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Verificar usuario en la base de datos
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id, $hashed_password);
    
    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $secret_key = "your_secret_key";
        $issuer = "your_website";
        $audience = "your_audience";
        $issued_at = time();
        $expiration_time = $issued_at + (60 * 60); // Token v谩lido por 1 hora
        
        $payload = array(
            "iss" => $issuer,
            "aud" => $audience,
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "data" => array(
                "user_id" => $user_id,
                "username" => $username
            )
        );

        $jwt = JWT::encode($payload, new Key($secret_key, 'HS256'));

        echo json_encode(array(
            "message" => "Inicio de sesi贸n exitoso.",
            "jwt" => $jwt
        ));
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Inicio de sesi贸n fallido."));
    }
    $stmt->close();
}
?>