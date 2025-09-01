<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Estudiantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
      body {
        background-color: #0d6efd; /* Azul institucional */
        color: #fff;
      }
      .navbar {
        background-color: #084298 !important; /* Azul más oscuro */
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
    <img class="img-fluid banner" src="banner.jpeg" alt="Banner Institucional">
    <!-- Navbar -->
    <nav class="navbar navbar-dark">
      <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="#">📊 Dashboard Estudiantes</a>
      </div>
    </nav>

    <!-- Contenido -->
    <div class="container mt-4">
      <div class="card p-4 bg-white text-dark">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold">Listado de Estudiantes</h4>
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregar">
            ➕ Agregar Estudiante
          </button>
        </div>

        <!-- Tabla con DataTable -->
        <div class="table-responsive">
          <table id="tablaEstudiantes" class="table table-striped table-hover" style="width:100%">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Nombre del Estudiante</th>
                <th>NIE</th>
                <th>Grado</th>
                <th>Sección</th>
                <th>Turno</th>
                <th>Demerito</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
<?php
require 'db.php';
$result = $conn->query("SELECT * FROM estudiantes ORDER BY id DESC");
$contador = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$contador}</td>
            <td>{$row['nombre']}</td>
            <td>{$row['nie']}</td>
            <td>{$row['grado']}</td>
            <td>{$row['seccion']}</td>
            <td>{$row['turno']}</td>
            <td>{$row['concepto']}</td>
            <td>{$row['fecha']}</td>
            <td>
              <button class='btn btn-warning btn-sm'>✏️</button>
              <button class='btn btn-danger btn-sm'>🗑</button>
            </td>
          </tr>";
    $contador++;
}
$conn->close();
?>
</tbody>

          </table>
        </div>
      </div>
    </div>

    <!-- Modal para Agregar Estudiante -->
<div class="modal fade" id="modalAgregar" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Agregar Estudiante</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form action="agregar_estudiantes.php" method="POST">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Nombre del Estudiante</label>
              <input type="text" class="form-control" name="nombre" placeholder="Ingrese el nombre completo" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">NIE</label>
              <input type="text" class="form-control" name="nie" placeholder="Ejemplo: 123456789" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-4">
              <label class="form-label" id="label">Grado</label>
              <input type="text" class="form-control" name="grado" placeholder="Ejemplo: 7°" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Sección</label>
              <input type="text" class="form-control" name="seccion" placeholder="Ejemplo: A" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Turno</label>
              <select class="form-select" name="turno" required>
                <option value="">Seleccione el turno</option>
                <option>Mañana</option>
                <option>Tarde</option>
                <option>Noche</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <!-- <label class="form-label">Concepto</label>
            <textarea class="form-control" name="concepto" rows="2" placeholder="Ingrese el motivo o concepto" required></textarea> -->
          <select class="form-select" name="concepto" required>
                <option value="">Seleccione una opción</option>
                <option>Portar mal o hacer mal uso del uniforme</option>
                <option>Cabello largo, tintado o no de acuerdo a lo establecido</option>
                <option>No saludar al entrar o salir del aula</option>
                <option>No decir “Por favor” al hacer una petición</option>
                <option>No decir “Gracias” al recibir un favor, materiales o atención</option>
                <option>Usar un tono grosero o irrespetuoso hacia compañeros, docentes o personal administrativo</option>

              </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" placeholder="Seleccione la fecha" required>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (necesario para DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
      $(document).ready(function () {
        $('#tablaEstudiantes').DataTable({
          language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
          }
        });

        // Simulación de agregar estudiante (sin backend aún)
        $('#formEstudiante').on('submit', function(e) {
          e.preventDefault();
          alert('✅ Registro guardado (ejemplo, aún no conectado a la base de datos).');
          $('#modalAgregar').modal('hide');
          this.reset();
        });
        // Enviar formulario con AJAX
$('#formEstudiante').on('submit', function(e) {
  e.preventDefault();

  $.ajax({
    type: "POST",
    url: "agregar_estudiante.php",
    data: $(this).serialize(),
    success: function(response) {
      alert(response);
      $('#modalAgregar').modal('hide');
      $('#formEstudiante')[0].reset();

      // Recargar DataTable (si tienes registros dinámicos)
      $('#tablaEstudiantes').DataTable().ajax.reload(null, false);
    }
  });
});

      });
    </script>
<?php include "footer.php"; ?>
  </body>
</html>
