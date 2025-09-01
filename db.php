<?php
$host = "localhost";   // servidor
$user = "root";        // usuario
$pass = "";            // contraseña
$db   = "demeritos";     // nombre de tu base de datos

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}
?>
