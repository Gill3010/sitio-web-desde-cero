<?php 
session_start();
require 'config.php'; // Conexión a la base de datos
error_reporting(E_ALL);
ini_set('display_errors', 1);

//echo '<pre>';
//print_r($_SESSION);
//echo '</pre>'; // encapsulado pero útil 

// Verifica si 'username' y 'user_id' están definidos en la sesión
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    // Manejo del error si 'username' no está definido
    echo "Error: 'username' no está definido en la sesión.";
    exit;
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Manejo del error si 'user_id' no está definido
    echo "Error: 'user_id' no está definido en la sesión.";
    exit;
}

$form_enviado = false; // Inicializa la variable para verificar el envío del formulario

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Capturar los datos del formulario con validación adicional
    $nombres = htmlspecialchars($_POST['nombres']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo 'Correo electrónico no válido.';
        exit;
    }
    $telefono = htmlspecialchars($_POST['telefono']);
    $institucion = htmlspecialchars($_POST['institucion']);
    $titulo_investigacion = htmlspecialchars($_POST['titulo_investigacion']);
    $pais = htmlspecialchars($_POST['pais']);
    $galeria = htmlspecialchars($_POST['galeria']);
    $instrucciones = htmlspecialchars($_POST['instrucciones']);
    $transaction_id = htmlspecialchars($_POST['transaction_id']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $payment_reference = htmlspecialchars($_POST['payment_reference']);
    $orcid = htmlspecialchars($_POST['orcid']); // Capturar el campo ORCID
    $username = $_SESSION['username'];
    $user_id = $_SESSION['user_id']; // Asegúrate de que user_id esté en la sesión

    // Validar que el pago fue realizado dependiendo del método
    if ($payment_method === 'paypal' && empty($transaction_id)) {
        echo 'Error: El pago no ha sido verificado.';
        exit;
    } elseif ($payment_method !== 'paypal' && empty($payment_reference)) {
        echo 'Error: Se requiere una referencia de pago.';
        exit;
    }

    // Inicializar arrays para almacenar las rutas de los archivos
    $archivos = [];
    $imagenes = [];
    $audios = [];

    // Directorio de subida
    $uploads_dir = 'uploads/sponsor';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    // Procesar los archivos subidos
    foreach ($_FILES['archivos']['name'] as $key => $name) {
        $tmp_name = $_FILES['archivos']['tmp_name'][$key];
        $file_type = mime_content_type($tmp_name);
        $file_ext = pathinfo($name, PATHINFO_EXTENSION);
        $file_path = "$uploads_dir/$name";

        // Comprobar tamaño del archivo (5MB límite aquí)
        if ($_FILES['archivos']['size'][$key] > 5 * 1024 * 1024) {
            echo 'Archivo demasiado grande.';
            continue;  // Saltar este archivo y continuar con los demás
        }

        if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            if (move_uploaded_file($tmp_name, $file_path)) {
                $imagenes[] = $file_path;
            } else {
                echo 'Error al subir la imagen.';
            }
        } elseif (in_array($file_type, ['audio/mpeg', 'audio/mp3'])) {
            if (move_uploaded_file($tmp_name, $file_path)) {
                $audios[] = $file_path;
            } else {
                echo 'Error al subir el audio.';
            }
        } else {
            if (move_uploaded_file($tmp_name, $file_path)) {
                $archivos[] = $file_path;
            } else {
                echo 'Error al subir el archivo.';
            }
        }
    }

    // Convertir los arrays a cadenas de texto
    $archivos = implode(',', $archivos);
    $imagenes = implode(',', $imagenes);
    $audios = implode(',', $audios);

    $codigo_registro = uniqid();

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO sponsor_registros (nombres, apellidos, email, telefono, institucion, titulo_investigacion, pais, galeria, instrucciones, archivos, imagenes, audios, codigo_registro, transaction_id, payment_method, payment_reference, orcid, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo 'Error en la preparación de la consulta: ' . $conn->error;
        exit;
    }

    $stmt->bind_param('ssssssssssssssssss', $nombres, $apellidos, $email, $telefono, $institucion, $titulo_investigacion, $pais, $galeria, $instrucciones, $archivos, $imagenes, $audios, $codigo_registro, $transaction_id, $payment_method, $payment_reference, $orcid, $user_id);
    $stmt->execute();

    if ($stmt->error) {
        echo 'Error en la ejecución de la consulta: ' . $stmt->error;
        exit;
    }

    $stmt->close();
    $conn->close();

    // Cambia la variable para indicar que el formulario ha sido enviado con éxito
    $form_enviado = true;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Apadrinamiento</title>
    <link rel="icon" href="/img/logo30.png" type="image/x-icon">
   <style>
        /* Estilos generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        /* Encabezado del formulario */
        .form-header img {
            height: 65px;
            margin-right: 30px;
        }

        /* Contenedor del formulario */
        .form-container,
        form {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Títulos */
        h2 {
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
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        textarea,
        input[type="file"],
        select {
            width: 100%;
            max-width: 400px;
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
        .label-instrucciones {
    text-align: left; /* Alineación a la izquierda */
    display: block; /* Hace que el label se comporte como un bloque, permitiendo el uso de text-align */
    margin-bottom: 10px; /* Añade un pequeño margen inferior */
}
.titulo-investigacion {
    display: none; /* Oculto por defecto */
    background-color: #f1f1f1; /* Color de fondo */
    padding: 10px; /* Espaciado */
    border-radius: 5px; /* Bordes redondeados */
    text-align: center; /* Centrar texto */
    margin-bottom: 10px; /* Espacio debajo */
    transition: all 0.3s ease; /* Transición suave */
}

.titulo-investigacion.playing {
    display: block; /* Mostrar cuando el audio está reproduciéndose */
    animation: fadeIn 0.5s; /* Animación para aparecer suavemente */
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
    </style>
</head>
<body>

    <!-- Mostrar mensaje de éxito si el formulario fue enviado -->
    <?php if ($form_enviado) : ?>
        <div class="success">Formulario enviado con éxito.</div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" id="sponsorForm">
        <div class="form-header">
            <a href="/Index.html"> <!-- Reemplaza con la URL a la que quieres enlazar -->
                <img src="/img/logo30.png" alt="Logo">
            </a>
        </div>
        <h2>Formulario de Apadrinamiento</h2>

        <input type="text" name="nombres" placeholder="Ingrese el nombre del Autor" required>
        <input type="text" name="apellidos" placeholder="Ingrese el apellido del Autor" required>
        <input type="email" name="email" placeholder="Ingrese el correo electrónico" required>
        <input type="tel" name="telefono" placeholder="Ingrese el número de teléfono" required>
        <input type="text" name="institucion" placeholder="Ingrese el nombre de la Institución" required>

        <!-- Nuevo campo de Título de la Investigación -->
        <input type="text" name="titulo_investigacion" placeholder="Ingrese el Título de la Investigación" required>
        <input type="text" name="orcid" placeholder="Ingrese su ORCID">

        <input type="text" name="pais" placeholder="Ingrese el país de origen" required>
        <input type="text" name="galeria" placeholder="Ingrese el nombre de la Galería">

        <!-- Instrucciones -->
        <label for="instrucciones" class="label-instrucciones">Instrucciones: </label>
        <textarea id="instrucciones" name="instrucciones" required>Indique el código de la galería o los códigos de los carteles que desee auspiciar.</textarea>

        <!-- Campo para subir archivos (imágenes, textos y audios) -->
        <label for="archivos">Subir Archivos (Imágenes, Textos, Audios):</label>
        <input type="file" id="archivos" name="archivos[]" multiple required>

        <!-- Contenedor para los audios -->
        <div id="audio-container">
            <!-- Aquí se muestra el botón de reproducción de audio dinámicamente -->
            <!-- Generar elementos dinámicos con JS si es necesario -->
        </div>

        <!-- Campo oculto para almacenar el transaction_id -->
        <input type="hidden" name="transaction_id" id="transaction_id">
      
        <!-- Incluye el SDK de PayPal -->
        <script src="https://www.paypal.com/sdk/js?client-id=AR2NHaJTMfmR0FReqTZbcqPJzsTRxxvwsUeAOMhEP6Ch3UfKp13NuRu9iRYeLG9h6vsQ_aeVt6sWXfqP"></script>

        <label for="payment_method">Método de Pago:</label>
        <select id="payment_method" name="payment_method" required>
            <option value="paypal">PayPal</option>
            <option value="western_union">Western Union</option>
            <option value="yappy">Yappy</option>
            <option value="transferencia">Transferencia Bancaria (Banco General)</option>
        </select>
        <br>

        <!-- Contenedor para detalles específicos de cada método de pago -->
        <div id="payment-details"></div>

        <!-- Botón de Pago PayPal (por defecto oculto) -->
        <div id="paypal-button-container" style="display: none;"></div> <br>

        <!-- Botón de Envío del Formulario (deshabilitado por defecto) -->
        <button type="submit" id="submit-button" disabled>Enviar</button>
    </form>

    <!-- Scripts JS -->
    <script>document.getElementById('payment_method').addEventListener('change', function() {
    const paymentMethod = this.value;
    const detailsContainer = document.getElementById('payment-details');
    const paypalButton = document.getElementById('paypal-button-container');
    const submitButton = document.getElementById('submit-button');

    // Resetear el formulario
    detailsContainer.innerHTML = '';
    paypalButton.style.display = 'none';
    submitButton.disabled = true;

    // Destruir el botón de PayPal si ya existe
    if (paypalButton.firstChild) {
        paypalButton.firstChild.remove();
    }

    const paymentInstructions = {
        'western_union': {
            text: 'Por favor, realice el pago a través de Western Union y proporcione la referencia del pago a nombre de Tania Rosana Kennedy Dupuy.',
            label: 'Referencia de Western Union:',
            inputId: 'western_union_reference'
        },
        'yappy': {
            text: 'Por favor, realice el pago a través de Yappy y proporcione la referencia del pago a nombre de Multiservicios TK.',
            label: 'Referencia de Yappy:',
            inputId: 'yappy_reference'
        },
        'transferencia': {
            text: 'Realice una transferencia bancaria al siguiente número de cuenta:<br>Banco General: 03-78-01-089981-8 (Cuenta Corriente)<br>A nombre de: Multiservicios TK',
            label: 'Referencia de Transferencia Bancaria:',
            inputId: 'bank_transfer_reference'
        }
    };

    if (paymentMethod === 'paypal') {
        paypalButton.style.display = 'block';
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{ amount: { value: '1.00' }}]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Pago completado por ' + details.payer.name.given_name);
                    document.getElementById('transaction_id').value = data.orderID; // Guarda el transaction_id
                    submitButton.disabled = false; // Habilita el botón de envío
                });
            },
            onCancel: function(data) {
                alert('Pago cancelado. Por favor, realice el pago para continuar.');
            },
            onError: function(err) {
                console.error('Error en el pago:', err);
            }
        }).render('#paypal-button-container');
    } else if (paymentInstructions[paymentMethod]) {
        const instructions = paymentInstructions[paymentMethod];
        detailsContainer.innerHTML = `
            <p>${instructions.text}</p>
            <label for="${instructions.inputId}">${instructions.label}</label>
            <input type="text" id="${instructions.inputId}" name="payment_reference" required>
        `;
        submitButton.disabled = false;
    }
});</script>
       

</body>
</html>


    </form>

    <div id="fileList">
        <!-- Aquí se pueden listar los archivos subidos si es necesario -->
    </div>

</body>
</html>
