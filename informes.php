<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Demeritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <style>
      body {
        background-color: #0d6efd;
        color: #fff;
      }
      .navbar {
        background-color: #084298 !important;
      }
      .card {
        border-radius: 12px;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.2);
      }
      .btn-primary {
        background-color: #0d6efd;
        border: none;
      }
      .btn-primary:hover {
        background-color: #084298;
      }
      .banner {
        width: 100%;
        max-height: 100px;
        object-fit: cover;
      }
      label {
        color:#0d6efd;
      }
    </style>
  </head>
  <body>
    <!-- Banner superior -->
    <img class="img-fluid banner" src="banner2.jpg" alt="Banner Institucional">

    <!-- Navbar -->
    <nav class="navbar navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">Generar informes</a>
      </div>
    </nav>

    <?php
    include "db.php";
    session_start();
    $codigo_infra = $_SESSION['codigo_infra'];

    $filtro_fecha = $_GET['fecha'] ?? '';
    $filtro_grado = $_GET['grado'] ?? '';
    $filtro_seccion = $_GET['seccion'] ?? '';
    // $filtro_demerito = $_GET['concepto'] ?? '';
    $filtro_turno = $_GET['turno'] ?? '';
    $filtro_nie = $_GET['nie'] ?? '';
    ?>

    <!-- Contenido -->
    <div class="container mt-4">
      <div class="card p-4 bg-white text-dark">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold">Generación de Informes de Demeritos</h4>
        </div>

        <!-- 🔎 Filtros Avanzados -->
  <form method="GET" class="row g-2 mb-4 p-3 bg-white rounded shadow-sm">
    <div class="col-md-2">
      <label class="form-label">Fecha</label>
      <input type="date" name="fecha" value="<?= htmlspecialchars($filtro_fecha) ?>" class="form-control">
    </div>
    <div class="col-md-2">
      <label class="form-label">Grado</label>
      <input type="text" name="grado" value="<?= htmlspecialchars($filtro_grado) ?>" class="form-control" placeholder="Ej: 9°">
    </div>
    <div class="col-md-2">
      <label class="form-label">Sección</label>
      <input type="text" name="seccion" value="<?= htmlspecialchars($filtro_seccion) ?>" class="form-control" placeholder="Ej: A">
    </div>
    <!-- <div class="col-md-2">
      <label class="form-label">Demerito</label>
      <input type="text" name="demerito" value="<?= htmlspecialchars($filtro_seccion) ?>" class="form-control" placeholder="Ej: A">
    </div> -->
    <div class="col-md-2">
      <label class="form-label">Turno</label>
      <select name="turno" class="form-select">
        <option value="">Todos</option>
        <option value="Mañana" <?= $filtro_turno=='Mañana'?'selected':'' ?>>Mañana</option>
        <option value="Tarde" <?= $filtro_turno=='Tarde'?'selected':'' ?>>Tarde</option>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">NIE</label>
      <input type="text" name="nie" value="<?= htmlspecialchars($filtro_nie) ?>" class="form-control" placeholder="Buscar NIE">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button type="submit" class="btn btn-primary w-100">Filtrar</button>
            <a href="?codigo_infra=<?php echo urlencode($codigo_infra); ?>" class="btn btn-secondary w-50">Limpiar</a>

    </div>
     
  </form>

    <!-- Tabla con DataTable -->
       <div class="table-responsive bg-white p-3 rounded shadow-sm">
    <table id="tablaEstudiantes" class="table table-striped table-hover align-middle" style="width:100%">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Fecha</th>
          <th>NIE</th>
          <th>Nombre</th>
          <th>Grado</th>
          <th>Sección</th>
          <th>Turno</th>
          <th>Demerito</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Construir la consulta con filtros
        $sql = "SELECT * FROM estudiantes WHERE codigo_infra = '$codigo_infra'";
        if ($filtro_fecha)   $sql .= " AND fecha = '$filtro_fecha'";
        if ($filtro_grado)   $sql .= " AND grado LIKE '%$filtro_grado%'";
        if ($filtro_seccion) $sql .= " AND seccion LIKE '%$filtro_seccion%'";
        if ($filtro_turno)   $sql .= " AND turno = '$filtro_turno'";
        if ($filtro_nie)     $sql .= " AND nie LIKE '%$filtro_nie%'";
        $sql .= " ORDER BY id DESC";

        $result = $conn->query($sql);
        $contador = 1;

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
              <td>{$contador}</td>
              <td>{$row['fecha']}</td>
              <td>{$row['nie']}</td>
              <td>{$row['nombre']}</td>
              <td>{$row['grado']}</td>
              <td>{$row['seccion']}</td>
              <td>{$row['turno']}</td>
              <td>{$row['concepto']}</td>
            </tr>";
            $contador++;
          }
        } else {
          echo "<tr><td colspan='8' class='text-center text-muted'>No se encontraron registros</td></tr>";
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>

  <div class="text-end mt-3">
    <a href="reporte_pdf.php?<?= http_build_query($_GET) ?>" class="btn btn-success" target="_blank">
      🧾 Generar PDF del filtro actual
    </a>
  </div>

</div>

<script>
$(document).ready(function() {
  $('#tablaEstudiantes').DataTable({
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
    },
    pageLength: 10,
    ordering: false
  });
});
</script>

         <div class="text-center">
            <a href="dashboard.php" class="btn btn-secondary">↩️ Regresar</a>
          </div>
      </div>

    <?php include "footer.php"; ?>
  </body>
</html>
