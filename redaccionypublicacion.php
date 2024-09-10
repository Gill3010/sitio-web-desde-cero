<?php
session_start();
require 'config.php';

// Crear conexión a la base de datos
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se han enviado los datos del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizar y validar los datos del formulario
    $nombre_completo = filter_var(trim($_POST['nombre_completo']), FILTER_SANITIZE_STRING);
    $correo = filter_var(trim($_POST['correo']), FILTER_SANITIZE_EMAIL);
    $telefono = filter_var(trim($_POST['telefono']), FILTER_SANITIZE_STRING);
    $asunto = filter_var(trim($_POST['asunto']), FILTER_SANITIZE_STRING);
    $mensaje = filter_var(trim($_POST['mensaje']), FILTER_SANITIZE_STRING);

    // Verificar que los campos no estén vacíos
    if (empty($nombre_completo) || empty($correo) || empty($telefono) || empty($asunto) || empty($mensaje)) {
        die("Todos los campos son obligatorios.");
    }

    // Validar correo electrónico
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    // Preparar la consulta SQL para prevenir inyección SQL
    $stmt = $conn->prepare("INSERT INTO contactos (nombre_completo, correo, telefono, asunto, mensaje) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Error al preparar la consulta SQL: " . $conn->error);
    }

    $stmt->bind_param("sssss", $nombre_completo, $correo, $telefono, $asunto, $mensaje);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos guardados exitosamente.";
    } else {
        echo "Error al guardar los datos: " . $stmt->error;
    }

    // Cerrar la declaración
    $stmt->close();
}

// Cerrar la conexión
$conn->close();
?>
<!Doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Redacción y Publicación Científica Galería-Virtual</title>
    <link rel="icon" href="img/logo30.png" type="image/x-icon">
    <meta name=“keywords” content=“galeria,virtual,invetigacion,aprendizaje,ficheros,poster,carteles,repositorio,publicación,congresos,científicos”>
    <meta name="description" content="Galería-Virtual.org">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://galeria-virtual.org/index.html">
    <meta property="og:title" content="Galería-Virtual 2024" />
    <meta property="og:description" content="Galería-Virtual 2024">
    <meta property="og:image:alt" content="Galeria-Virtual 2024">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Galería-Virtual 2024">
    <meta name="twitter:description" content="Galería-Virtual 2024">
    <link rel="canonical" href="https://info@galeria-virtual.org">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/estilo1.css">
    <link rel="stylesheet" type="text/css" href="css/estilo2.css">
    <link rel="stylesheet" type="text/css" href="css/estilo3.css">
    <link rel="stylesheet" type="text/css" href="css/fontello.css">
    <link rel="stylesheet" href="css/btn.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.1/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glider-js@1.7.9/glider.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/banner.css">
    <style>  body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }
    
    .contact-form {
        width: 400px;
        margin: 50px auto;
        padding: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    .contact-form h2 {
        margin-bottom: 20px;
        color: #333;
    }
    
    .contact-form label {
        display: block;
        margin-bottom: 8px;
        color: #666;
    }
    
    .contact-form input[type="text"],
    .contact-form input[type="email"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    
    .contact-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        background-color: #00008b;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    
    .contact-form input[type="submit"]:hover {
        background-color: #00008b;
    }</style>
</head>

<body>
    <div class="d-flex px-3 py-2" id="encabezado" role="banner">
        <div>
            <a href="Index.html" target="_blank" title="Sitio web de GV"><img src="img/logo30.png" class="logo_dgtic"
                    alt="GV"></a>
        </div>
        <div class="pl-3 pl-lg-5 d-flex align-items-center flex-fill justify-content-lg-left">
            <h1 class="h1-header"><span class="sr-only">SALA DE EXPOSICION DIGITAL CIENTIFICA (Galeria-Virtual),
                    <strong></span>GALERIA-VIRTUAL</h1></strong> <br>
        </div>
 <p>Ciencia, Innovación y Tecnología</p>
    </div>
    <div class="d-flex px-3 py-2" id="encabezado" role="banner">
    </div>
         <nav class="navbar navbar-expand-lg shadow px-2 px-lg-3 py-2" id="menu" role="menubar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarGaleria-Virtual"
            aria-controls="navbarGaleria-Virtual" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburguesa"><span></span><span></span><span></span></div>
        </button>
        <div class="collapse navbar-collapse" id="navbarGaleria-Virtual">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <a href="Index.html" class="icon-inicio"></a>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2 ml-2" href="Nosotros.html">Nosotros</a>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownGaleria" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Politicas de publicación
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownGaleria">
                        <a class="dropdown-item" href="declaraciondeaccesoabierto.html">Declaración de acceso
                            abierto</a>
                        <a class="dropdown-item" href="derechosdelosautoresylectores.html">Derechos de los autores y
                            lectores</a>
                        <a class="dropdown-item" href="evaluacionabierta.html">Evaluación abierta</a>
                        <a class="dropdown-item" href="licenciasdepublicacion.html">Licencias de publicación </a>
                        <a class="dropdown-item" href="comunicacion.html">Comunicación</a>
                        <a class="dropdown-item" href="antiplagio.html">Antiplagio</a>
                        <a class="dropdown-item" href="criterioseticosdepublicacion.html">Criterios éticos de
                            publicación</a>
                        <a class="dropdown-item" href="declaraciondeprivacidad.html">Declaración de privacidad</a>
                        <a class="dropdown-item" href="referencias.html">Referencias bibliograficas</a>
                    </div>
                </li>
              <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1 " id="navbarDropdownPrograma"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Servicios
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownPrograma">
                        <a class="dropdown-item" href="salagaleriavirtual.php">Sala o Galería virtual de afiches
                        </a>
                        <a class="dropdown-item" href="cursosdecapacitacion.php">Cursos de capacitación</a>
                        <a class="dropdown-item" href="organizaciondeinformacion.php">Organización de información
                        </a>
                        <a class="dropdown-item" href="disenodeafiches.php">Diseño de Afiches/Carteles 
                        </a>
                        <a class="dropdown-item" href="redaccionypublicacion.php">Redacción y publicación científica
                        </a>
                        <a class="dropdown-item" href="normasapa.php">Normas APA para redacción 
                        </a>
                        <a class="dropdown-item" href="asesoriaenlaorganizacion.php">Organización de Eventos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownConvocatoria"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Salas
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownConvocatoria">
                        <a class="dropdown-item" href="aquienesestadirigido.html">¿A quiénes está dirigido?</a>
                        <a class="dropdown-item" href="condicionesyrequisitos.html">Condiciones y Requisitos</a>
                        <a class="dropdown-item" href="beneficios.html">Beneficios de utilizar Galeria-Virtual</a>
                        <a class="dropdown-item" href="solicitarsala.html">¿Cómo solicitar una sala?</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownConvocatoria"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Galerías
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownConvocatoria">
                        <a class="dropdown-item" href="ficherosactuales.php">Actuales</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2 ml-2" href="alianzasestrategicas.html">Alianzas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link mx-lg-2 ml-2" href="padrino.html">Padrinos</a>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownConvocatoria"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Iniciar Sesión
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownConvocatoria">
                        <a class="dropdown-item" href="index2.php">Iniciar Sesión</a>
                        <a class="dropdown-item" href="Formperfil.php">Crear Perfil</a>
                         <a class="dropdown-item" href="editprofile.php">Editar Perfil</a>
                        <a class="dropdown-item" href="viewprofile.php">Agregar Fichero</a>
                    </div>
                </li>
                
            </ul>
        </div>
    </nav>
        </head>
        <main>
            <img src="img/redaccionypublicacion.jpg" class="banner"> 
            <div class=" bg-gris-2">
                <div class="container px-lg-5 bg-white">
                    <div class="pt-4 pb-5">
                        <div class="d-flex flex-column mb-3">
                            <h2>Organización de Información desde Informes Finales, Tesis, Artículos para hacer Afiches o 
                                Carteles
                            </h2>
                        </div>
                        <div>
                            <p class="text-justify">
                                La redacción científica tiene un sólo propósito: informar el resultado de una investigación. Tu meta como autor de un artículo científico no es alegrar, entristecer, enfurecer, divertir, ni impresionar al lector; tu única meta es comunicar eficazmente el resultado de tu investigación.
                                
                                <strong class="font-weight-bold"> Una publicación científica es  un documento formal que presenta los resultados de una investigación rigurosa en un campo del conocimiento, siguiendo normas establecidas por la comunidad científica. Normalmente, se publica en revistas revisadas por expertos o en actas de conferencias.</strong>
                            </p>
                            <p class="text-justify">
                                <strong class="font-weight-bold">¿Cómo desarrollar documentos correctamente redactados? </strong> <br> Te ayudamos a lograr presentaciones que cumplan con las exigencias académicas científicas y que sean aprobados exitosamente.
                                <br>
                           </p>
                           <section id="contacto" class="contacto-seccion">
                            <div class="container">
                                <h2>Contacto</h2>
<form action="" method="POST" class="formulario-contacto">
<div class="form-group">
    <label for="nombre_completo">Nombre Completo:</label>
    <input type="text" id="nombre_completo" name="nombre_completo" class="form-control" required>
</div>
<div class="form-group">
    <label for="correo">Correo Electrónico:</label>
    <input type="email" id="correo" name="correo" class="form-control" required>
</div>
<div class="form-group">
    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" name="telefono" class="form-control" required>
</div>
<div class="form-group">
    <label for="asunto">Asunto:</label>
    <input type="text" id="asunto" name="asunto" class="form-control" required>
</div>
<div class="form-group">
    <label for="mensaje">Mensaje:</label>
    <textarea id="mensaje" name="mensaje" rows="5" class="form-control" required></textarea>
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary">Enviar</button>
</div>
</form>
                            </div>
                        </section>
                        </div>
                    </div>
                 <div>                        <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill mr-1" viewBox="0 0 16 16">
                                    <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z"/>
                                    <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"/>
                                </svg>  
                                <a class="text-reverse" href="mailto:selene.martinez@icat.unam.mx?subject=Duda del Simposio 2023">gro.lautriv-airelag@ofni</a>
                            </p>
                            <p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill mr-1" viewBox="0 0 16 16">
                                    <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z"/>
                                    <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"/>
                                </svg>  
                                <a class="text-reverse" href="mailto:libia.eslava@icat.unam.mx?subject=Duda del Simposio 2023">gro.lautriv-airelag@ofni</a>
                            </p>
                        </div>
                    </div>
    
                </div>
            </div>
        </main>
    <footer class="pt-5 pb-3" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-7">
                <h3>Acerca de nosotros</h3>
                <img src="images/logo-dgtic.png" class="img-fluid py-3" alt="">
                <p>La SALA DE EXPOSICION DIGITAL CIENTIFICA es un espacio científico destinado a
                    promover y difundir propuestas gráficas científicas resultados de investigaciones como
                    respuesta a convocatorias solicitadas en Congresos, Simposios, Encuentros u otras actividades
                    similares basadas en procesos de Ciencia Abierta, normas COPE y evaluación por pares
                    ciegos.</p>
                <ul class="list-unstyled">
                    <li><a href="https://educatic.unam.mx/aviso-privacidad.html" target="_blank"
                            rel="noopener">Aviso de privacidad</a></li>
                </ul>
                <address>
                    <p>Multiservicios TK RUC 3-89-1892 DV 73 Río Abajo, calle 5ta, edif. LA QUINTA LOCAL C4 TELEFONO
                        6645-7685 / 208-4689.</p>
                </address>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-5">
                <h3 class="mt-4 mt-md-0 h3">Contacto</h3>
                <ul class="list-unstyled">
                    <li>
                        <a href="mailto:info@redipai.virtual.org">
                            <!-- SVG de correo -->
                            <span class="text-reverse">gro.lautriv-airelag@ofni</span>
                        </a>
                    </li>
                    <li><a href="https://www.facebook.com/CTEhabitatpuma" target="_blank">
                            <!-- SVG de Facebook -->
                            @Cuenta Facebook</a></li>
                    <li>
                        <a href="https://twitter.com/habitatPumaUNAM" target="_blank">
                            <!-- SVG de Twitter -->
                            @Cuenta Twitter</a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/user/HabitatPuma" target="_blank">
                            <!-- SVG de YouTube -->
                            @Canal de Youtube
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-12">
                <h3 class="mt-4 mt-md-0 h3">Encuentros anteriores </h3>
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle" style="color: #ffb606; background-color: transparent; border: none; font-size: 1rem; padding: 0; margin-top: 1rem; text-decoration: underline;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ver Encuentros Anteriores
                    </button>
                    <ul class="dropdown-menu list-unstyled" aria-labelledby="dropdownMenuButton" style="padding: 0; margin: 0;">
                        <li>
                            <a class="dropdown-item" href="../educatic2022/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2023
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2021/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2022
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2020/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2021
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2019/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2020
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2018/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2019
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2017/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2018
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2016/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2017
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="../educatic2015/index.html" style="color: #00008b; background-color: #ffb606; text-decoration: none; display: block; padding: 8px 16px;">
                                #Galería-Virtual2016
                            </a>
                        </li>
                    </ul>
                    
                    <style>
                        /* Estilo para el efecto hover de los elementos de la lista */
                        .dropdown-menu .dropdown-item:hover {
                            color: #00008b !important; /* Color del texto al pasar el ratón */
                            background-color: #ffffff !important; /* Color de fondo al pasar el ratón */
                        }
                    </style>
                </div>
            </div>
        </div>
        <hr class="bg-white">
        <div class="row">
            <div class="col-12 copy">
                <p>Hecho en Panamá, Multiservicios TK, todos los derechos reservados 2024.</p>
                <p>Sitio y sistema web administrado por Multiservicios TK </p>
                <p>Multiservicios TK.</p>
            </div>
        </div>
    </div>
</footer>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
                integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
                crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
                crossorigin="anonymous"></script>
            <script async src="https://www.googletagmanager.com/gtag/js?id=G-8HZCFQ1NPY"></script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', 'G-8HZCFQ1NPY');
            </script>
            <script>
                window.dataLayer = window.dataLayer || [];
                function gtag() { dataLayer.push(arguments); }
                gtag('js', new Date());
                gtag('config', 'G-28P93QGF1P');
            </script>
            <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.9/glider.min.js"></script>
            <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/glider-js@1.7.9/glider.min.js"></script>
            <script src="js/app.js"></script>
</body>

</html>