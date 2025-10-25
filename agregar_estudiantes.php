<?php
session_start();
include "db.php";

$nombre = $_POST['nombre'];
$nie = $_POST['nie'];
$grado = $_POST['grado'];
$seccion = $_POST['seccion'];
$turno = $_POST['turno'];
$concepto = $_POST['concepto'];
$observacion = $_POST['observacion'] ?? '';
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$codigo_infra = $_SESSION['codigo_infra']; // 👈 se toma del usuario logueado

$sql = "INSERT INTO estudiantes (nombre, nie, grado, seccion, turno, concepto, observacion, fecha, hora, codigo_infra)
        VALUES ('$nombre', '$nie', '$grado', '$seccion', '$turno', '$concepto', '$observacion', '$fecha', '$hora','$codigo_infra')";

if ($conn->query($sql)) {
    echo "✅ Registro guardado correctamente";
    header ("location: dashboard.php");
} else {
    echo "❌ Error al guardar: ";
    echo "Consulte con el administrador del sistema";
    header ("location: index.html");
}

$conn->close();
?>
