<?php
session_start();
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nie = trim($_POST['nie']);
    //$codigo_infra = $_SESSION['codigo_infra']; // Se filtra por el centro del usuario logueado

    // Buscar registros del estudiante
    $sql = "SELECT nombre, COUNT(*) AS total_demeritos 
            FROM estudiantes 
            WHERE nie = '$nie' 
            GROUP BY nombre";
    $resultado = $conn->query($sql);
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Consulta de Deméritos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Modal de resultado -->
<div class="modal fade show" id="modalResultado" tabindex="-1" style="display:block;" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Resultado de la Consulta</h5>
      </div>
      <div class="modal-body text-center">

<?php
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
        $nombre = htmlspecialchars($row['nombre']);
        $total = $row['total_demeritos'];

        echo "
        <h5 class='fw-bold text-success mb-3'>Estudiante: $nombre</h5>
        <h1 class='display-3 text-primary'>$total</h1>
        <p class='text-muted'>Deméritos acumulados</p>";
    } else {
        echo "
        <div class='alert alert-warning'>
          <strong>⚠️ No se encontraron registros</strong><br>
          No existen deméritos para el NIE <strong>$nie</strong> en este centro educativo.
        </div>";
    }
?>
      </div>
      <div class="modal-footer">
        <a href="index.html" class="btn btn-secondary">Cerrar</a>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Mostrar el modal automáticamente
  const modal = new bootstrap.Modal(document.getElementById('modalResultado'));
  modal.show();

  // Cuando el modal se cierre, redirigir al index.html
  const modalElement = document.getElementById('modalResultado');
  modalElement.addEventListener('hidden.bs.modal', function () {
    window.location.href = 'index.html';
  });
</script>

</body>
</html>

<?php
    $conn->close();
}
?>
