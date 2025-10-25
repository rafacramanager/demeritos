<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];
    $nie = $_POST['nie'];
    $nombre = $_POST['nombre'];
    $grado = $_POST['grado'];
    $seccion = $_POST['seccion'];
    $turno = $_POST['turno'];
    $concepto = $_POST['concepto'];
    $observacion = isset($_POST['observacion']) ? $_POST['observacion'] : '';

    $sql = "UPDATE estudiantes 
            SET fecha='$fecha', nie='$nie', nombre='$nombre', grado='$grado', 
                seccion='$seccion', turno='$turno', concepto='$concepto', observacion='$observacion' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registro actualizado correctamente'); window.location='ver_demeritos.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
