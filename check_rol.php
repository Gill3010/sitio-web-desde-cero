<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirigir a la página de inicio de sesión si no hay usuario autenticado
    exit();
}

if ($_SESSION['user_rol'] != 'administrador') {
    echo "Acceso denegado. No tienes los permisos necesarios para ver esta página.";
    exit();
}
?>
<!-- Aquí va el contenido exclusivo para administradores -->
<h1>Panel de Administrador</h1>