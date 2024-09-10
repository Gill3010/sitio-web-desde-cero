<?php
session_start();
require 'config.php';

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombres = htmlspecialchars($_POST['nombres']);
    $apellidos = htmlspecialchars($_POST['apellidos']);
    $email = htmlspecialchars($_POST['email']);
    $telefono = htmlspecialchars($_POST['telefono']);
    $institucion = htmlspecialchars($_POST['institucion']);
    $pais = htmlspecialchars($_POST['pais']);
    $galeria = htmlspecialchars($_POST['galeria']);
    $instrucciones = htmlspecialchars($_POST['instrucciones']);
    $transaction_id = htmlspecialchars($_POST['transaction_id']);
    $payment_method = htmlspecialchars($_POST['payment_method']);
    $payment_reference = htmlspecialchars($_POST['payment_reference']);
    $username = $_SESSION['username'];
    
    // Validar que el pago fue realizado dependiendo del m谷todo
    if ($payment_method === 'paypal' && empty($transaction_id)) {
        die('Error: El pago no ha sido verificado.');
    } elseif ($payment_method !== 'paypal' && empty($payment_reference)) {
        die('Error: Se requiere una referencia de pago.');
    }

    // Inicializar arrays para almacenar las rutas de los archivos
    $archivos = [];
    $imagenes = [];
    $audios = [];

    // Directorio de subida
    $uploads_dir = 'uploads/submission';
    if (!is_dir($uploads_dir)) {
        mkdir($uploads_dir, 0777, true);
    }

    // Procesar los archivos subidos
    foreach ($_FILES['archivos']['name'] as $key => $name) {
        $tmp_name = $_FILES['archivos']['tmp_name'][$key];
        $file_type = mime_content_type($tmp_name); 
        $file_ext = pathinfo($name, PATHINFO_EXTENSION); 
        $file_path = "$uploads_dir/$name";

        if (in_array($file_type, ['image/jpeg', 'image/png', 'image/gif'])) {
            move_uploaded_file($tmp_name, $file_path);
            $imagenes[] = $file_path;
        } elseif (in_array($file_type, ['audio/mpeg', 'audio/mp3'])) {
            move_uploaded_file($tmp_name, $file_path);
            $audios[] = $file_path;
        } else {
            move_uploaded_file($tmp_name, $file_path);
            $archivos[] = $file_path;
        }
    }

    // Convertir los arrays a cadenas de texto
    $archivos = implode(',', $archivos);
    $imagenes = implode(',', $imagenes);
    $audios = implode(',', $audios);

    $codigo_registro = uniqid();

    // Consulta SQL para insertar los datos en la base de datos
    $sql = "INSERT INTO submission_registros (nombres, apellidos, email, telefono, institucion, pais, galeria, instrucciones, archivos, imagenes, audios, codigo_registro, transaction_id, payment_method, payment_reference)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparaci車n de la consulta: ' . $conn->error);
    }

    // Verifica el tipo de par芍metros a pasar en bind_param
    $stmt->bind_param('sssssssssssssss', $nombres, $apellidos, $email, $telefono, $institucion, $pais, $galeria, $instrucciones, $archivos, $imagenes, $audios, $codigo_registro, $transaction_id, $payment_method, $payment_reference);
    $stmt->execute();

    if ($stmt->error) {
        die('Error en la ejecuci車n de la consulta: ' . $stmt->error);
    }

    $stmt->close();
    $conn->close();

    header("Location: submit_form.php?success=true");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de Postulación</title>
        <link rel="icon" href="img/logo30.png" type="image/x-icon">

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
    </style>
</head>
<body>

    <?php if (isset($_GET['success'])) { echo '<div class="success">Formulario enviado con éxito.</div>'; } ?>
    
    <form action="process_submission.php" method="post" enctype="multipart/form-data" id="submissionForm" >
         <div class="form-header">
            <img src="img/logo30.png" alt="Logo"></div>
        <h2>Formulario de Postulación</h2>

        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" required>
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" required>
        
        <label for="email">Correo Electrónico Institucional:</label>
        <input type="email" id="email" name="email" required>
        
        <label for="telefono">Número de Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
        
        <label for="institucion">Institución:</label>
        <input type="text" id="institucion" name="institucion" required>
        
        <label for="pais">País:</label>
        <input type="text" id="pais" name="pais" required>
        
        <label for="galeria">Galería o Evento que Desea Patrocinar:</label>
        <input type="text" id="galeria" name="galeria" required>
        
      <label for="instrucciones" class="label-instrucciones">Instrucciones: <br>
    Enviar cada cartel digital en formato JPG o PNG.<br />
    Cada trabajo enviado debe contar con su explicación.<br />
    El audio en formato MP3 con duración máxima de un minuto.<br />
    El texto máximo de 300 palabras en formato DOC o DOCX.<br />
    El cartel debe incluir los créditos y una licencia de derechos de autor Creative Commons 4.0.<br />
    Todos los carteles deben haber sido sometidos a revisión por pares.<br />
    El cartel debe ser inédito. No se aceptan trabajos que hayan sido presentados o publicados en otros eventos académicos.<br />
    Los proponentes de la GALERIA asumen todas las responsabilidades de originalidad y autoría de los archivos presentados.
</label>
        <textarea id="instrucciones" name="instrucciones" required>Indique el código de la galería o los códigos de los carteles que desee auspiciar.</textarea>
        
                <label for="archivos">Subir Texto:</label>
        <input type="file" id="archivos" name="archivos[]" multiple required>
        
        <label for="archivos">Subir Imagen:</label>
        <input type="file" id="archivos" name="archivos[]" multiple required>
        
        <label for="archivos">Subir Audio:</label>
        <input type="file" id="archivos" name="archivos[]" multiple required>


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

        <script>
        document.getElementById('payment_method').addEventListener('change', function() {
    var paymentMethod = this.value;
    var detailsContainer = document.getElementById('payment-details');
    var paypalButton = document.getElementById('paypal-button-container');
    var submitButton = document.getElementById('submit-button');

    // Reset form
    detailsContainer.innerHTML = '';
    paypalButton.style.display = 'none';
    submitButton.disabled = true;

    // Destruir el botón de PayPal si ya existe
    if (paypalButton.firstChild) {
        paypalButton.firstChild.remove();
    }

    if (paymentMethod === 'paypal') {
        paypalButton.style.display = 'block';
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.00' // Precio que el usuario debe pagar
                        }
                    }]
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
    } else if (paymentMethod === 'western_union') {
        detailsContainer.innerHTML = `
            <p>Por favor, realice el pago a través de Western Union y proporcione la referencia del pago a nombre de Tania Rosana Kennedy Dupuy.</p> 
            <label for="western_union_reference">Referencia de Western Union:</label>
            <input type="text" id="western_union_reference" name="payment_reference" required>
            
        `;
        submitButton.disabled = false;
    } else if (paymentMethod === 'yappy') {
        detailsContainer.innerHTML = `
            <p>Por favor, realice el pago a través de Yappy y proporcione la referencia del pago a nombre de Multiservicios TK.</p>
            <label for="yappy_reference">Referencia de Yappy:</label>
            <input type="text" id="yappy_reference" name="payment_reference" required>
            
        `;
        submitButton.disabled = false;
    } else if (paymentMethod === 'transferencia') {
        detailsContainer.innerHTML = `
            <p>Realice una transferencia bancaria al siguiente número de cuenta:<br>
            Banco General: 04-04-96-594816-7 (Cuenta Corriente)<br>
            A nombre de: Multiservicios TK</p>
            <label for="bank_transfer_reference">Referencia de Transferencia Bancaria:</label>
            <input type="text" id="bank_transfer_reference" name="payment_reference" required>
            
        `;
        submitButton.disabled = false;
    }
});
        </script>
    </form>

</body>
</html>