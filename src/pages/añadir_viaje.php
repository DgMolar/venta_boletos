<?php
require_once "../utils/conexion_db.php";
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
    <title>Añadir Viajes</title>
    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/navbar/navbar.js"></script>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container"></div>
    <!-- Formulario -->
    <div class="container">
      <div class="row justify-content-center my-3">
        <div class="col-6">
          <div
            id="formularioContainer"
            class="border p-5">
            <form action="./viajes/añadir_viaje.php" method="POST">
              <div class="h3 text-center">Añadir</div>
              <div class="form-group">
                  <label for="id_destino">Destino</label>
                  <select class="form-control" id="id_destino" name="id_destino"> 
                      <!-- Opciones de Destino extraídas de la base de datos -->
                      <option value="" selected>Seleccione alguno</option>
                      <?php
                      // Realizar la consulta para obtener los destinos
                      $consultaDestinos = "SELECT * FROM destinos";
                      $resultDestinos = $conexion->query($consultaDestinos);

                      if ($resultDestinos->num_rows > 0) {
                          // Iterar sobre los resultados y generar las opciones del select
                          while ($rowDestinos = $resultDestinos->fetch_assoc()) {
                              $idDestino = $rowDestinos['id_destino'];
                              $nombreDestino = $rowDestinos['nombre'];

                              echo "<option value='$idDestino'>$nombreDestino</option>";
                          }
                      } else {
                          echo "<option value=''>No hay destinos disponibles</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class="form-group">
                  <label for="fecha_salida">Fecha Salida</label>
                  <input
                      type="datetime-local"
                      class="form-control"
                      id="fecha_salida"
                      name="fecha_salida" 
                  />
              </div>
              <div class="form-group">
                  <label for="fecha_llegada">Fecha Llegada</label>
                  <input
                      type="datetime-local"
                      class="form-control"
                      id="fecha_llegada"
                      name="fecha_llegada" 
                  />
              </div>
              <div class="form-group">
                <label for="estado_viaje">Estado Viaje</label>
                <select class="form-control" id="estado_viaje" name="estado_viaje"> 
                  <option value="venta" selected>Venta</option>
                </select>
              </div>
              <div class="form-group">
                  <label for="costo">Costo</label>
                  <input
                      type="text"
                      class="form-control"
                      id="costo"
                      name="costo" 
                      placeholder="$0.00"
                  />
              </div>
              <div class="form-group">
                  <label for="id_autobus">Autobús</label>
                  <select class="form-control" id="id_autobus" name="id_autobus"> 
                      <option value="" selected>Seleccione alguno</option>
                      <?php
                      // Realizar la consulta para obtener los autobuses
                      $consultaAutobuses = "SELECT * FROM autobuses  WHERE estado = 'disponible'";
                      $resultAutobuses = $conexion->query($consultaAutobuses);

                      if ($resultAutobuses->num_rows > 0) {
                          // Iterar sobre los resultados y generar las opciones del select
                          while ($rowAutobuses = $resultAutobuses->fetch_assoc()) {
                              $idAutobus = $rowAutobuses['id_autobus'];
                              $placaAutobus = $rowAutobuses['placa'];

                              echo "<option value='$idAutobus'>$placaAutobus</option>";
                          }
                      } else {
                          echo "<option value=''>No hay autobuses disponibles</option>";
                      }
                      ?>
                  </select>
              </div>
              <div class="text-center">
                  <button type="submit" class="btn btn-success">Enviar</button>
              </div>
          </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE JS-->
    <!-- <script type="module" src="./viajes/ver_viajes.js"></script> -->

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
