<?php
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

function validate_jwt($jwt) {
    $secret_key = "your_secret_key";

    if ($jwt) {
        try {
            // Decodifica el JWT con el método actualizado que utiliza `Key`
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
            return $decoded->data;
        } catch (\Firebase\JWT\ExpiredException $e) {
            // Token expirado
            return "Token expirado.";
        } catch (\Firebase\JWT\SignatureInvalidException $e) {
            // Firma del token inválida
            return "Firma del token inválida.";
        } catch (\Exception $e) {
            // Cualquier otro error relacionado con JWT
            return "Error en la validación del token: " . $e->getMessage();
        }
    }
    return null;
}
?>