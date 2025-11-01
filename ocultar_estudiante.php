<?php
include "db.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "UPDATE estudiantes SET estado = 'Oculto' WHERE id = '$id'";
    if ($conn->query($sql)) {
        echo "<script>alert('Demerito eliminado correctamente'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar demerito'); window.location='dashboard.php';</script>";
    }
}
$conn->close();
?>
