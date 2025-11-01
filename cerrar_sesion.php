<?php
session_start();
session_unset();     // Elimina todas las variables de sesión
session_destroy();   // Destruye la sesión actual

// Redirige al formulario de login
header("Location: index.html");
exit();
?>
