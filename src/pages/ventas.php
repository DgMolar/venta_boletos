<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
  // Si no hay sesión iniciada, redirigir al usuario al formulario de inicio de sesión
  header("Location: ./auth/login.html");
  exit; // Terminar el script para evitar que se siga ejecutando
}

// Si hay sesión iniciada, puedes acceder a $_SESSION['correo'] para obtener el correo del usuario
$correoUsuario = $_SESSION['correo'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Bs Icons -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    />
    <!-- Bootstrap 4.0.0 -->
    <link
      rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    />
    <title>Ventas</title>
    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/navbar/navbar.js"></script>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container"></div>

    <!-- Contenido principal -->
    <div class="container">
      <div class="text-center mt-5 mb-4">
        <h1>Bienvenido a ver ventas</h1>
      </div>

      <!-- Formulario de selección de parámetros -->
      <form id="filtroForm">
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="fechaInicio">Fecha de inicio</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" required>
          </div>
          <div class="form-group col-md-3">
            <label for="fechaFin">Fecha de fin</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" required>
          </div>
          <div class="form-group col-md-3">
            <label for="ordenamiento">Ordenamiento</label>
            <select class="form-control" id="ordenamiento" name="ordenamiento">
              <option value="">Sin ordenamiento</option>
              <option value="id_boleto">ID Boleto</option>
              <option value="correo_empleado">Correo Empleado</option>
            </select>
          </div>
          <div class="form-group col-md-3">
            <button type="submit" class="btn btn-primary mt-4">Filtrar</button>
          </div>
        </div>
      </form>

      <!-- Tabla de resultados -->
      <div class="row">
        <div class="col">
          <table class="table table-striped table-hover table-bordered text-center">
            <!-- Encabezados de la tabla -->
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID Venta</th>
                <th scope="col">ID Boleto</th>
                <th scope="col">Total</th>
                <th scope="col">Metodo de Pago</th>
                <th scope="col">Empleado</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody id="tablaResultados"></tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE JS-->
    <script type="module" src="./ventas/ver_ventas.js"></script>

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
