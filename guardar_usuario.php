<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo_infra = $_POST['codigo_infra'];
    $nombre_docente = $_POST['nombre_docente'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    // Cifrar la contraseña
    //$hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Insertar en la base de datos
    $sql = "INSERT INTO usuarios (codigo_infra, nombre_docente, usuario, contraseña)
            VALUES ('$codigo_infra', '$nombre_docente', '$usuario', '$contraseña')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Usuario agregado correctamente'); window.location='index.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
