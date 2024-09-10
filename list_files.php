<?php
require 'config.php';
require 'validate_token.php'; // Funci贸n para validar JWT

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $jwt = $_GET['jwt'] ?? '';
    $validation_result = validate_jwt($jwt);

    if ($validation_result) {
        $user_id = $validation_result->user_id;

        // Obtener archivos del usuario
        $stmt = $conn->prepare("SELECT file_id, file_path FROM files WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $files = $result->fetch_all(MYSQLI_ASSOC);
        
        echo json_encode($files);
        $stmt->close();
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Token inv谩lido."));
    }
}
?>