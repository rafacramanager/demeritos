<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Demeritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
        <a class="navbar-brand fw-bold" href="#">📊 Detalle de Demeritos</a>
      </div>
    </nav>

    <?php
    include "db.php";

    // Verifica que se haya recibido el ID
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM estudiantes WHERE id = $id";
        $resultado = $conn->query($sql);

        if ($resultado->num_rows > 0) {
            $row = $resultado->fetch_assoc();
        } else {
            echo "<div class='alert alert-danger text-center mt-4'>No se encontró el registro.</div>";
            exit();
        }
    } else {
        echo "<div class='alert alert-warning text-center mt-4'>No se especificó el ID.</div>";
        exit();
    }
    ?>

    <!-- Contenido -->
    <div class="container mt-4">
      <div class="card p-4 bg-white text-dark">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h4 class="fw-bold">Editar Información del Demérito</h4>
        </div>

        <form action="actualizar_demerito.php" method="POST">
          <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" name="fecha" value="<?php echo $row['fecha']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="nie" class="form-label">NIE</label>
            <input type="text" class="form-control" name="nie" value="<?php echo $row['nie']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="grado" class="form-label">Grado</label>
            <input type="text" class="form-control" name="grado" value="<?php echo $row['grado']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="seccion" class="form-label">Sección</label>
            <input type="text" class="form-control" name="seccion" value="<?php echo $row['seccion']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="turno" class="form-label">Turno</label>
            <input type="text" class="form-control" name="turno" value="<?php echo $row['turno']; ?>" required>
          </div>

          <div class="mb-3">
            <label for="concepto" class="form-label">Concepto</label>
            <select class="form-select" name="concepto" required onchange="mostrarCampoOtro()">
              <option value="">Seleccione una opción</option>
              <option <?php if($row['concepto']=="Portar mal o hacer mal uso del uniforme") echo "selected"; ?>>Portar mal o hacer mal uso del uniforme</option>
              <option <?php if($row['concepto']=="Cabello largo, tintado o no de acuerdo a lo establecido") echo "selected"; ?>>Cabello largo, tintado o no de acuerdo a lo establecido</option>
              <option <?php if($row['concepto']=="No saludar al entrar o salir del aula") echo "selected"; ?>>No saludar al entrar o salir del aula</option>
              <option <?php if($row['concepto']=="No decir “Por favor” al hacer una petición") echo "selected"; ?>>No decir “Por favor” al hacer una petición</option>
              <option <?php if($row['concepto']=="No decir “Gracias” al recibir un favor, materiales o atención") echo "selected"; ?>>No decir “Gracias” al recibir un favor, materiales o atención</option>
              <option <?php if($row['concepto']=="Usar un tono grosero o irrespetuoso hacia compañeros, docentes o personal administrativo") echo "selected"; ?>>Usar un tono grosero o irrespetuoso hacia compañeros, docentes o personal administrativo</option>
              <option value="Otro" <?php if($row['concepto']=="Otro") echo "selected"; ?>>Otro</option>
            </select>
          </div>

          <div class="mb-3" id="campo_otro" style="display: none;">
            <label for="observacion" class="form-label">Especifique la observación</label>
            <input type="text" class="form-control" id="observacion" name="observacion" value="<?php echo isset($row['observacion']) ? $row['observacion'] : ''; ?>">
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
            <a href="dashboard.php" class="btn btn-secondary">↩️ Regresar</a>
          </div>
        </form>
      </div>
    </div>

    <script>
    // Mostrar campo "Otro"
    function mostrarCampoOtro() {
      const select = document.querySelector("select[name='concepto']");
      const campoOtro = document.getElementById("campo_otro");
      const observacion = document.getElementById("observacion");

      if (select.value === "Otro") {
        campoOtro.style.display = "block";
        observacion.setAttribute("required", "true");
      } else {
        campoOtro.style.display = "none";
        observacion.removeAttribute("required");
      }
    }

    // Llamar al cargar la página por si ya está seleccionado "Otro"
    window.onload = mostrarCampoOtro;
    </script>

    <?php include "footer.php"; ?>
  </body>
</html>
