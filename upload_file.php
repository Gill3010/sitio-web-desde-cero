<?php
require 'config.php';
require 'validate_token.php'; // Función para validar JWT

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jwt = $_POST['jwt'] ?? '';
    $validation_result = validate_jwt($jwt);
    
    if ($validation_result) {
        $user_id = $validation_result->user_id;

        // Manejo del archivo
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $file = 'uploads/' . basename($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $file)) {
                // Guarda la información del archivo en la base de datos
                $stmt = $conn->prepare("INSERT INTO files (user_id, file_path) VALUES (?, ?)");
                $stmt->bind_param("is", $user_id, $file);
                if ($stmt->execute()) {
                    echo json_encode(array("message" => "Archivo subido con éxito."));
                } else {
                    http_response_code(500);
                    echo json_encode(array("message" => "Error al guardar el archivo en la base de datos."));
                }
                $stmt->close();
            } else {
                http_response_code(500);
                echo json_encode(array("message" => "Error al mover el archivo."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No se recibió ningún archivo o hubo un error al cargarlo."));
        }
    } else {
        http_response_code(401);
        echo json_encode(array("message" => "Token inválido."));
    }
}
?>