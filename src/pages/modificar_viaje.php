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

// Verificar si se proporciona un "idViaje" en la URL
$idViaje = null;
if (isset($_GET['idViaje'])) {
  $idViaje = $_GET['idViaje'];
}

// Obtener los datos del viaje si se está actualizando
if ($idViaje) {
  $sql = "SELECT * FROM viajes WHERE id_viaje = ?";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("i", $idViaje);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $idDestino = $row['id_destino'];
    $fechaSalida = $row['fecha_salida'];
    $fechaLlegada = $row['fecha_llegada'];
    $estadoViaje = $row['estado_viaje'];
    $costo = $row['costo'];
    $idAutobus = $row['id_autobus'];
  } else {
    // No se encontró el viaje con el "idViaje" proporcionado
    echo '<script>alert("El viaje no existe."); window.location.href = "../ver_viajes.php";</script>';
    exit;
  }

  $stmt->close();
}

// Obtener destinos disponibles
$sqlDestinos = "SELECT * FROM destinos";
$resultadoDestinos = $conexion->query($sqlDestinos);

// Consulta para obtener el autobús seleccionado
$sqlAutobusSeleccionado = "SELECT * FROM autobuses WHERE id_autobus = ?";
$stmtAutobusSeleccionado = $conexion->prepare($sqlAutobusSeleccionado);
$stmtAutobusSeleccionado->bind_param("i", $idAutobus);
$stmtAutobusSeleccionado->execute();
$resultadoAutobusSeleccionado = $stmtAutobusSeleccionado->get_result();

// Consulta para obtener los autobuses disponibles
$sqlAutobusesDisponibles = "SELECT * FROM autobuses WHERE estado = 'disponible'";
$resultadoAutobusesDisponibles = $conexion->query($sqlAutobusesDisponibles);
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
    <title>Añadir/Editar Viaje</title>
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
            <form action="./viajes/modificar_viaje.php" method="POST">
              <div class="h3 text-center">Añadir/Editar Viaje</div>
              <div class="form-group">
                <label for="id_destino">Destino</label>
                <select class="form-control" id="id_destino" name="id_destino">
                  <!-- Código para generar las opciones del select -->
                  <?php
                  while ($rowDestino = $resultadoDestinos->fetch_assoc()) {
                    $idDestinoOption = $rowDestino['id_destino'];
                    $nombreDestino = $rowDestino['nombre'];
                    echo '<option value="' . $idDestinoOption . '"';
                    if ($idDestinoOption == $idDestino) { // Cambiar === por ==
                      echo ' selected';
                    }
                    echo '>' . $nombreDestino . '</option>';
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
                  value="<?php echo $fechaSalida ?? ''; ?>"
                />
              </div>
              <div class="form-group">
                <label for="fecha_llegada">Fecha Llegada</label>
                <input
                  type="datetime-local"
                  class="form-control"
                  id="fecha_llegada"
                  name="fecha_llegada"
                  value="<?php echo $fechaLlegada ?? ''; ?>"
                />
              </div>
              <div class="form-group">
                <label for="estado_viaje">Estado Viaje</label>
                <select class="form-control" id="estado_viaje" name="estado_viaje"> 
                  <option value="venta" <?php if ($estadoViaje === 'venta') echo 'selected'; ?>>Venta</option>
                  <option value="finalizado" <?php if ($estadoViaje === 'finalizado') echo 'selected'; ?>>Finalizado</option>
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
                  value="<?php echo $costo ?? ''; ?>"
                />
              </div>
              <div class="form-group">
                <label for="id_autobus">Autobús</label>
                <select class="form-control" id="id_autobus" name="id_autobus">
                  <!-- Código para generar las opciones del select -->
                  <?php
                  // Mostrar opción seleccionada
                  if ($resultadoAutobusSeleccionado->num_rows === 1) {
                    $rowAutobusSeleccionado = $resultadoAutobusSeleccionado->fetch_assoc();
                    $idAutobusSeleccionado = $rowAutobusSeleccionado['id_autobus'];
                    $placaAutobusSeleccionado = $rowAutobusSeleccionado['placa'];
                    echo '<option value="' . $idAutobusSeleccionado . '" selected>' . $placaAutobusSeleccionado . '</option>';
                  }

                  // Mostrar opciones disponibles
                  while ($rowAutobus = $resultadoAutobusesDisponibles->fetch_assoc()) {
                    $idAutobus = $rowAutobus['id_autobus'];
                    $placa = $rowAutobus['placa'];
                    echo '<option value="' . $idAutobus . '">' . $placa . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="text-center">
                <input type="hidden" name="id_viaje" value="<?php echo $idViaje ?? ''; ?>" />
                <button type="submit" class="btn btn-success">Guardar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer>
      <!-- Agrega el contenido de tu footer aquí -->
    </footer>

    <!-- Bootstrap 4.0.0 Scripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
