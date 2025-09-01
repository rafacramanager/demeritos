<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre   = $_POST['nombre'];
    $nie      = $_POST['nie'];
    $grado    = $_POST['grado'];
    $seccion  = $_POST['seccion'];
    $turno    = $_POST['turno'];
    $concepto = $_POST['concepto'];
    $fecha    = $_POST['fecha'];

    $sql = "INSERT INTO estudiantes (nombre, nie, grado, seccion, turno, concepto, fecha)
            VALUES ('$nombre', '$nie', '$grado', '$seccion', '$turno', '$concepto', '$fecha')";

    if ($conn->query($sql) === TRUE) {
        echo "✅ Registro agregado correctamente";
    } else {
        echo "❌ Error: " . $conn->error;
    }
}
$conn->close();
?>
