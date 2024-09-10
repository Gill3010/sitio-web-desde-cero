<?php
session_start();
require_once 'config.php'; // Asegúrate de que config.php contiene la configuración de conexión a la base de datos

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index2.php");
    exit;
    die("Error: Sesión no válida.");
}

// Obtener el ID del cartel a editar desde la URL
$file_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id']; // Obtener el user_id del usuario que ha iniciado sesión

// Verificar si el ID es válido
if ($file_id > 0) {
    // Obtener los detalles del cartel desde la base de datos
    $query = "SELECT user_id, nombres, apellidos, institucion, titulo_investigacion, orcid, imagenes, archivos, audios FROM sponsor_registros WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $file_id);
    $stmt->execute();
    $stmt->bind_result($db_user_id, $nombresActual, $apellidosActual, $institucionActual, $tituloInvestigacionActual, $orcidActual, $imagenesActual, $archivosActual, $audiosActual);
    $stmt->fetch();
    $stmt->close();

    // Verificar que el usuario tiene permiso para editar el registro
    if ($db_user_id !== $user_id) {
        echo "<div class='error'>No tienes permiso para editar este registro.</div>";
        exit;
    }

    // Verificar si el formulario fue enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Proceso de actualización de imagen, texto y audio
        $nombres = htmlspecialchars(trim($_POST['nombres']));
        $apellidos = htmlspecialchars(trim($_POST['apellidos']));
        $institucion = htmlspecialchars(trim($_POST['institucion']));
        $titulo_investigacion = htmlspecialchars(trim($_POST['titulo_investigacion']));
        $orcid = htmlspecialchars(trim($_POST['orcid']));

        // Definir la ruta de subida
        $uploadDir = 'uploads/sponsor/';
        $imagenesPath = $imagenesActual;  // Usar las imágenes actuales como valor predeterminado
        $archivosPath = $archivosActual;  // Usar los archivos actuales como valor predeterminado
        $audiosPath = $audiosActual;  // Usar los audios actuales como valor predeterminado

        // Manejo de imágenes
        if (isset($_FILES['imagenes']) && $_FILES['imagenes']['error'] == UPLOAD_ERR_OK) {
            $imagenesExt = pathinfo($_FILES['imagenes']['name'], PATHINFO_EXTENSION);
            $imagenesPath = $uploadDir . uniqid('img_') . '.' . $imagenesExt;
            if (move_uploaded_file($_FILES['imagenes']['tmp_name'], $imagenesPath)) {
                // Eliminar la imagen anterior si se subió una nueva
                if (!empty($imagenesActual) && file_exists($imagenesActual)) {
                    unlink($imagenesActual);
                }
            }
        }

        // Manejo de archivos de texto
        if (isset($_FILES['archivos']) && $_FILES['archivos']['error'] == UPLOAD_ERR_OK) {
            $archivosExt = pathinfo($_FILES['archivos']['name'], PATHINFO_EXTENSION);
            $archivosPath = $uploadDir . uniqid('file_') . '.' . $archivosExt;
            if (move_uploaded_file($_FILES['archivos']['tmp_name'], $archivosPath)) {
                // Eliminar el archivo anterior si se subió uno nuevo
                if (!empty($archivosActual) && file_exists($archivosActual)) {
                    unlink($archivosActual);
                }
            }
        }

        // Manejo de audios
        if (isset($_FILES['audios']) && $_FILES['audios']['error'] == UPLOAD_ERR_OK) {
            $audiosExt = pathinfo($_FILES['audios']['name'], PATHINFO_EXTENSION);
            $audiosPath = $uploadDir . uniqid('audio_') . '.' . $audiosExt;
            if (move_uploaded_file($_FILES['audios']['tmp_name'], $audiosPath)) {
                // Eliminar el audio anterior si se subió uno nuevo
                if (!empty($audiosActual) && file_exists($audiosActual)) {
                    unlink($audiosActual);
                }
            }
        }

        // Actualizar la base de datos con los nuevos valores
        $updateQuery = "UPDATE sponsor_registros SET nombres = ?, apellidos = ?, institucion = ?, titulo_investigacion = ?, orcid = ?, imagenes = ?, archivos = ?, audios = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('ssssssssi', $nombres, $apellidos, $institucion, $titulo_investigacion, $orcid, $imagenesPath, $archivosPath, $audiosPath, $file_id);
        if ($stmt->execute()) {
            echo "<div class='success'>Cartel actualizado con éxito.</div>";
        } else {
            echo "<div class='error'>Error al actualizar el cartel.</div>";
        }
        $stmt->close();
    }
} else {
    echo "<div class='error'>ID de cartel no válido.</div>";
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cartel</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
    <!-- Agregar enlaces a CSS y otros recursos necesarios -->
    <style>
        /* Estilos del formulario */
        /* Aquí van tus estilos existentes */
            <style>/* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    color: #333;
    margin: 0;
    padding: 20px;
}

/* Contenedor del formulario */
.form-container,
form {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* Encabezado del formulario */
.form-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px; /* Agregar margen inferior para espacio */
}

.form-header {
    display: flex;
    flex-direction: column; /* Cambiar a columna para centrar verticalmente */
    align-items: center; /* Centra horizontalmente */
    justify-content: center; /* Centra verticalmente */
    margin-bottom: 20px; /* Agregar margen inferior para espacio */
    text-align: center; /* Centra el texto dentro del contenedor */
}

.form-header img {
    height: 65px;
    margin-bottom: 10px; /* Cambiar el margen derecho a margen inferior */
}

/* Títulos */
h1 {
    color: #2c3e50;
    text-align: center;
    margin-bottom: 20px;
}

h3 {
    margin-bottom: 15px;
    color: #555;
}

/* Etiquetas y campos de entrada */
label {
    display: block;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 5px;
    color: #333;
    text-align: left; /* Ajuste para alineación */
}

input[type="text"],
input[type="email"],
input[type="tel"],
textarea,
input[type="file"],
select {
    width: 100%;
    max-width: 500px;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    margin-bottom: 15px;
    box-sizing: border-box;
}

/* Estilo del botón */
button {
    background-color: #ffb606;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    width: 100%;
    max-width: 400px;
    margin: 10px 0;
}

button:hover {
    background-color: #00008b;
}

/* Estilo de la lista de archivos */
#fileList {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.file-item {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    margin-bottom: 15px;
    width: 100%;
    max-width: 600px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.file-item span {
    font-size: 16px;
    color: #2c3e50;
}

.file-item button {
    background-color: #e74c3c;
    color: #fff;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease;
    margin-left: 5px;
}

.file-item button:hover {
    background-color: #c0392b;
}

.file-item button:first-of-type {
    background-color: #2ecc71;
}

.file-item button:first-of-type:hover {
    background-color: #27ae60;
}

/* Estilo del mensaje de éxito */
.success {
    color: #5bc0de;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
}

/* Estilo del mensaje de error */
.error {
    color: #e74c3c;
    font-weight: bold;
    margin-bottom: 15px;
    text-align: center;
}

/* Etiquetas adicionales */
.label-instrucciones {
    text-align: left; /* Alineación a la izquierda */
    display: block; /* Hace que el label se comporte como un bloque, permitiendo el uso de text-align */
    margin-bottom: 10px; /* Añade un pequeño margen inferior */
}

/* Ajustes de estilos adicionales */
textarea {
    min-height: 100px;
}</style>
    </style>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <!-- Mostrar los campos existentes y permitir su edición -->
        <div class="form-header">
            <a href="/Index.html"> <!-- Reemplaza con la URL a la que quieres enlazar -->
                <img src="/img/logo30.png" alt="Logo">
            </a>
        </div>
        <h1>Editar Cartel</h1>

        <label for="nombres">Nombres:</label>
        <input type="text" name="nombres" value="<?php echo htmlspecialchars($nombresActual); ?>" required>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo htmlspecialchars($apellidosActual); ?>" required>

        <label for="institucion">Institución:</label>
        <input type="text" name="institucion" value="<?php echo htmlspecialchars($institucionActual); ?>" required>

        <label for="titulo_investigacion">Título de la Investigación:</label>
        <input type="text" name="titulo_investigacion" value="<?php echo htmlspecialchars($tituloInvestigacionActual); ?>" required>

        <label for="orcid">ORCID:</label>
        <input type="text" name="orcid" value="<?php echo htmlspecialchars($orcidActual); ?>" required>

        <!-- Manejo de imágenes -->
        <label for="imagenes">Imagen Actual:</label>
        <?php if (!empty($imagenesActual)): ?>
            <img src="<?php echo htmlspecialchars($imagenesActual); ?>" alt="Imagen actual" style="max-width: 100px;"><br>
        <?php endif; ?>
        <label for="imagenes">Nueva Imagen:</label>
        <input type="file" name="imagenes"><br>

        <!-- Manejo de archivos -->
        <label for="archivos">Archivo de Texto Actual:</label>
        <?php if (!empty($archivosActual)): ?>
            <img src="<?php echo htmlspecialchars($archivosActual); ?>" alt="Archivo actual" style="max-width: 100px;"><br>
        <?php endif; ?>
        <label for="archivos">Nuevo Archivo de Texto:</label>
        <input type="file" name="archivos"><br>

        <!-- Manejo de audios -->
        <label for="audios">Audio Actual:</label>
        <?php if (!empty($audiosActual)): ?>
            <img src="<?php echo htmlspecialchars($audiosActual); ?>" alt="Audio actual" style="max-width: 100px;"><br>
        <?php endif; ?>
        <label for="audios">Nuevo Audio:</label>
        <input type="file" name="audios"><br>

        <button type="submit">Actualizar Cartel</button>
    </form>
</body>
</html>