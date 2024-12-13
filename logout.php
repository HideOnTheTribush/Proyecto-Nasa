<?php
session_start();
session_destroy(); // Eliminamos toda la información de la sesión
header("Location: login.php"); // Redirigirmos al login
exit;
?>