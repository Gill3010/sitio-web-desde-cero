<?php
require 'config.php';
require 'validate_token.php'; // Funci贸n para validar JWT

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $jwt = $_GET['jwt'] ?? '';
    $file_id = $_GET['file_id'] ?? '';
    $validation_result = validate_jwt($jwt);

    if ($validation_result) {
        $user_id = $validation_result->user_id;

        // Obtener la ruta del archivo del usuario
        $stmt = $conn->prepare("SELECT file_path FROM files WHERE user_id = ? AND file_id = ?");
        $stmt->bind_param("ii", $user_id, $file_id);
        $stmt->execute();
        $stmt->bind_result($file_path);
        if ($stmt->fetch()) {
            if (file_exists($file_path)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
                exit;
            } else {
                http_response_code(404);
                echo json_encode(array("message" => "Archivo no encontrado."));
            }
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Archivo no encontrado."));
        }
        $stmt->close();
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Token inv谩lido."));
    }
}
?>