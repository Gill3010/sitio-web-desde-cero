<?php
session_start();

require 'config.php';



$sql = "SELECT * FROM submission_registros ORDER BY id DESC";
$result = $conn->query($sql);


?>
<!Doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Galerías anteriores Galería-Virtual</title>
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
        <p>Ciencia, Innovavción y Tecnología</p>
    </div>
    <div class="d-flex px-3 py-2" id="encabezado" role="banner">
    </div>
    <nav class="navbar navbar-expand-lg shadow px-2 px-lg-3 py-2" id="menu" role="menubar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarGaleria-Virtual"
            aria-controls="navbarGaleria-Virtual" aria-expanded="false" aria-label="Toggle navigation">
            <div class="hamburguesa"><span></span><span></span><span></span></div>
        </button>
        <a href="index.php"
            class="button-glow d-lg-none" role="button">Iniciar Sesión</a>
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
                        <a class="dropdown-item" href="salaogaleria.html">Sala o Galería virtual de afiches o carteles
                            para eventos particulares.
                        </a>
                        <a class="dropdown-item" href="../programa-conferencias.html">Cursos de capacitación</a>
                        <a class="dropdown-item" href="../programa-mesas-de-dialogo.html">Organización de información
                            desde informes finales, tesis, artículos para hacer afiches/carteles.
                        </a>
                        <a class="dropdown-item" href="../programa-talleres.html">Diseño de afiches/carteles científicos
                            modernos. (formatos, colores, ilustraciones, tamaños y otros).
                            o Divulgación científica en redes sociales.
                        </a>
                        <a class="dropdown-item" href="../simposio-adelf.html">Redacción y publicación científica.
                        </a>
                        <a class="dropdown-item" href="../simposio-adelf.html">Normas APA para redacción científica
                        </a>
                        <a class="dropdown-item" href="">Asesoría en la organización de eventos científicos</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownConvocatoria"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Salas
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownConvocatoria">
                        <a class="dropdown-item" href="aquienesestadirigido.html">¿A quiénes está dirigido?</a>
                        <a class="dropdown-item" href="condicionesyrequisitos.html">Condiciones y Requisitos</a>
                        <a class="dropdown-item" href="beneficios.html">Beneficios de utilizar Redipai.Virtual</a>
                        <a class="dropdown-item" href="solicitarsala.html">¿Cómo solicitar una sala?</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <div class="nav-link mx-lg-2 ml-2 dropdown-toggle menu-n1" id="navbarDropdownConvocatoria"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Galerías
                    </div>
                    <div class="dropdown-menu border-0" aria-labelledby="navbarDropdownConvocatoria">
                        <a class="dropdown-item" href="ficherosactuales.php">Actuales</a>
                        <a class="dropdown-item" href="../convocatoria-cartel.html">Anteriores</a>
                    </div>
                </li>
                <a class="nav-link mx-lg-2 ml-2" href="alianzasestrategicas.html">Alianzas estratégicas</a>
                <a class="nav-link mx-lg-2 ml-2" href="padrino.html">Padrino</a>
                <a class="nav-link mx-lg-2 ml-2" href="index.php">Login</a>
            </ul>
        </div>
    </nav>
        </head>
        <main>
            <div class="bg_gradiente_2" id="header-tit">
                <img src="img/ficheros2.jpg" class="banner">
            </div>
            <div class="my-3 galeria">
                <div class="my-4 my-md-0 ">
                    <div class="container-xl">
                        <h2>Bienvenidos a la galería de ficheros digitales Galería.Virtual 2024</h2>
                        <p class="lead mb-0">
                            Nuestro sitio posee diversas salas en las que puedes efectuar exposiciones temporales y actividades científicas tales como: <strong>Encuentros, conferencias,seminarios,foros de discución,cursos,talleres,certámenes y en general</strong>
                            , todos aquellos programas orientados a impulsar el conocimiento, la ciencia y todas las acciones que promueven la divulgación y puesta en valor de la producción científica.
                        </p>
                        <div class="row pb-3">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-12 col-sm-6 col-lg-4 col-xl-3 px-3 py-5">
            <div class="card h-100">
                
                <?php
                // Mostrar imagen
                if ($row['imagenes']) {
                    $imagenes = explode(',', $row['imagenes']);
                    foreach ($imagenes as $imagen) {
                        echo '<a href="'.htmlspecialchars($imagen).'"><img src="'.htmlspecialchars($imagen).'" class="img-fluid card-img-top" alt="Miniatura del cartel" data-toggle="tooltip" data-placement="top" title="Dé clic para abrir el cartel"></a>';
                    }
                }
                ?>
                
                <div class="card-body">
                    <p class="card-text">
                        Autor/a <br>
                        <?php echo htmlspecialchars($row['nombres'] . ' ' . $row['apellidos']); ?> <br>
                    </p>
                </div>
                <div class="card-footer">
                    <!-- Mostrar resumen (archivo de texto) -->
                    
                    <?php
                    if ($row['archivos']) {
                        $archivos = explode(',', $row['archivos']);
                        foreach ($archivos as $archivo) {
                            
                               
                                echo '<a href="'.htmlspecialchars($archivo).'" title="Dé clic para ver resumen">Resumen</a><br>';
                            
                        }
                    }
                    ?>
                    
                    
                    <!-- Mostrar audio -->
                    <?php
                    if ($row['audios']) {
                        $audios = explode(',', $row['audios']);
                        foreach ($audios as $audio) {
                            echo '<p>Audio del fichero</p>';
                            echo '<a href="'.htmlspecialchars($audio).'" title="Dé clic para escuchar audio" class="icon-audio"></a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
   
                            
                            <!--END-->
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
                        <p>La SALA DE EXPOSICION DIGITAL CIENTIFICA es un espacio científico destinado a promover y difundir propuestas gráficas científicas resultados de investigaciones como respuesta a convocatorias solicitadas en Congresos, Simposios, Encuentros u otras actividades similares basadas en procesos de Ciencia Abierta, normas COPE y evaluación por pares ciegos.</p>
                        <ul class="list-unstyled">
                            <li><a href="https://educatic.unam.mx/aviso-privacidad.html" target="_blank" rel="noopener">Aviso de privacidad</a></li>
                        </ul>
                        <address>
                            <p>Multiservicios TK 
                                RUC 3-89-1892  DV 73
                                Río Abajo, calle 5ta, edif. LA QUINTA LOCAL C4
                                TELEFONO 6645-7685 / 208-4689.
                            </p>
                        </address>
                    </div>					
                    <div class="col-xl-4 col-lg-4 col-md-5">
                        <h3 class="mt-4 mt-md-0 h3">Contacto</h3>
                        <ul class="list-unstyled">
                            <li>
                                <a href="mailto:info@redipai.virtual.org">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill mr-1" viewBox="0 0 16 16">
                                        <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z"/>
                                        <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"/>
                                      </svg>  
                                    <span  class="text-reverse">gro.lautriv-airelag@ofni</span>
                                </a>
                            </li>	
                            <li><a href="https://www.facebook.com/CTEhabitatpuma" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook mr-1" viewBox="0 0 16 16">
                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                  </svg>
                                @Cuenta Facebook</a></li>
                            <li>
                                <a href="https://twitter.com/habitatPumaUNAM" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter mr-1" viewBox="0 0 16 16">
                                <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                </svg>
                                @Cuenta Twitter</a>
                            </li>
                            <li>
                                <a href="https://www.youtube.com/user/HabitatPuma" target="_blank">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-youtube mr-1" viewBox="0 0 16 16">
                                        <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.007 2.007 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.007 2.007 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31.4 31.4 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.007 2.007 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A99.788 99.788 0 0 1 7.858 2h.193zM6.4 5.209v4.818l4.157-2.408L6.4 5.209z"/>
                                      </svg>    
                                    @Canal de Youtube
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-12">
                        <h3 class="mt-4 mt-md-0 h3">Encuentros anteriores </h3>
                        <ul class="list-unstyled">
                            <li><a href="../educatic2022/index.html">#Galería-Virtual2023</a></li>
                            <li><a href="../educatic2021/index.html">#Galería-Virtual2022</a></li>
                            <li><a href="../educatic2020/index.html">#Galería-Virtual2021</a></li>
                            <li><a href="../educatic2019/index.html">#Galería-Virtual2020</a></li>
                            <li><a href="../educatic2018/index.html">#Galería-Virtual2019</a></li>
                            <li><a href="../educatic2017/index.html">#Galería-Virtual2018</a></li>
                            <li><a href="../educatic2016/index.html">#Galería-Virtual2017</a></li>
                            <li><a href="../educatic2015/index.html">#Galería-Virtual2016</a></li>
                        </ul>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-8HZCFQ1NPY"></script>
        <script>
            $('#galleryModal').on('show.bs.modal', function(e) {
                $('#galleryImage').attr("src", $(e.relatedTarget).data("large-src"));
            });

            $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-8HZCFQ1NPY');
        </script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-28P93QGF1P');
        </script>
    </body>
</html>
