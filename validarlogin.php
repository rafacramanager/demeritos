<?php
session_start(); 
include "db.php";

// Verificar que se enviaron los datos
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Buscar el usuario
    $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();

        // Si las contraseñas no están cifradas, compara directamente
        if ($password == $fila['contraseña']) {

            // Guardar datos en sesión
            $_SESSION['id'] = $fila['id'];
            $_SESSION['nombre_docente'] = $fila['nombre_docente'];
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['codigo_infra'] = $fila['codigo_infra']; 
            $_SESSION['centro_educativo'] = $fila['centro_educativo'];


            // Redirigir al panel principal
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location='index.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location='index.html';</script>";
    }

    $conn->close();
} else {
    echo "<script>alert('Debe completar todos los campos'); window.location='index.html';</script>";
}
?>
