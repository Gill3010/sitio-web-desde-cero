<?php
// Conectar a la base de datos
$mysqli = new mysqli("localhost", "usuario", "contraseña", "base_de_datos");

if ($mysqli->connect_error) {
    die("Conexión fallida: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $descripcion = $_POST['descripcion'];

    // Preparar la consulta para actualizar la descripción
    $stmt = $mysqli->prepare("UPDATE archivos SET descripcion = ? WHERE id = ?");
    $stmt->bind_param("si", $descripcion, $id);
    $stmt->execute();

    // Verificar si se subió un nuevo archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileSize = $_FILES['archivo']['size'];
        $fileType = $_FILES['archivo']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validar y mover el archivo subido
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx'); // Añade las extensiones que permitas
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // Actualizar la ruta del archivo en la base de datos
                $stmt = $mysqli->prepare("UPDATE archivos SET archivo = ? WHERE id = ?");
                $stmt->bind_param("si", $dest_path, $id);
                $stmt->execute();
            } else {
                echo "Error al mover el archivo.";
            }
        } else {
            echo "Extensión de archivo no permitida.";
        }
    }

    // Redirigir a una página de éxito o al formulario
    header("Location: exito.php");
    exit();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Archivo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .form-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-header img {
            height: 65px;
            margin-bottom: 20px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
        }
        img {
            margin: 10px 0;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            display: block;
            margin: 20px auto;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Archivo</h2>
        <form action="editar_archivo.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">

            <!-- Campo para elegir un nuevo archivo (opcional) -->
            <div class="form-group">
                <label for="archivo">Elegir nuevo archivo:</label>
                <input type="file" class="form-control" id="archivo" name="archivo">
            </div>

            <!-- Campo para editar la descripción del archivo -->
            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <textarea class="form-control" id="descripcion" name="descripcion"><?php echo htmlspecialchars($row['descripcion'], ENT_QUOTES, 'UTF-8'); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</body>
</html>