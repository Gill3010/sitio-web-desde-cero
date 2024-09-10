<?php
require 'config.php';
require 'validate_token.php'; // Función para validar JWT

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $jwt = $_DELETE['jwt'] ?? '';
    $file_id = $_DELETE['file_id'] ?? '';
    $validation_result = validate_jwt($jwt);

    if ($validation_result) {
        $user_id = $validation_result->user_id;

        // Obtener la ruta del archivo del usuario
        $stmt = $conn->prepare("SELECT file_path FROM files WHERE user_id = ? AND file_id = ?");
        $stmt->bind_param("ii", $user_id, $file_id);
        $stmt->execute();
        $stmt->bind_result($file_path);
        if ($stmt->fetch()) {
            if (unlink($file_path)) {
                $stmt = $conn->prepare("DELETE FROM files WHERE user_id = ? AND file_id = ?");
                $stmt->bind_param("ii", $user_id, $file_id);
                if ($stmt->execute()) {
                    echo json_encode(array("message" => "Archivo eliminado con éxito."));
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error al eliminar el archivo de la base de datos."));
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Error al eliminar el archivo del sistema."));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Archivo no encontrado."));
        }
        $stmt->close();
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Token inválido."));
    }
}
?>