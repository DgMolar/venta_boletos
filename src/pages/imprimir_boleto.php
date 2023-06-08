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
require_once "../utils/conexion_db.php";

// Obtener los valores de idViaje y asientoSeleccionado del query string
$idViaje = $_GET['idViaje'];
$asientoSeleccionado = $_GET['asientoSeleccionado'];
// Consulta SQL para obtener los datos del boleto
$consulta = "SELECT * FROM venta_boletos.vista_boletos WHERE id_viaje = $idViaje AND numero_asiento = $asientoSeleccionado";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado && mysqli_num_rows($resultado) > 0) {
  // Mostrar e imprimir el boleto
  $boleto = mysqli_fetch_assoc($resultado);
  //guardar resultado en variables para poder imprimir en el pdf
  $idViaje = $boleto['id_viaje'];
  $idBoleto = $boleto['id_boleto'];
  $nombre = $boleto['nombre'];
  $apellido = $boleto['apellido'];
  $fecha = $boleto['fecha_salida'];
  $destino = $boleto['destino'];
  $numeroAsiento = $boleto['numero_asiento'];
  $costo = $boleto['costo'];
  $nombreEmpleado = $boleto['nombre_empleado'];
  $placas = $boleto['placa'];
} else {
  // No se encontraron boletos con los parámetros proporcionados
  echo "No se encontraron boletos.";
}

mysqli_close($conexion);
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
    <title>Venta de Boletos de Autobús</title>
    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/navbar/navbar.js"></script>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container"></div>

    <!-- BOLETO -->
    <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card mt-5">
          <div class="card-body">
            <h5 class="card-title text-center h1">Detalles del Boleto</h5>
            <table class="table">
              <tr>
                <th>ID Viaje:</th>
                <td><?php echo $idViaje; ?></td>
              </tr>
              <tr>
                <th>ID Boleto:</th>
                <td><?php echo $idBoleto; ?></td>
              </tr>
              <tr>
                <th>Nombre:</th>
                <td><?php echo $nombre; ?></td>
              </tr>
              <tr>
                <th>Apellido:</th>
                <td><?php echo $apellido; ?></td>
              </tr>
              <tr>
                <th>Fecha de Salida:</th>
                <td><?php echo $fecha; ?></td>
              </tr>
              <tr>
                <th>Destino:</th>
                <td><?php echo $destino; ?></td>
              </tr>
              <tr>
                <th>Número de Asiento:</th>
                <td><?php echo $numeroAsiento; ?></td>
              </tr>
              <tr>
                <th>Costo:</th>
                <td>$<?php echo $costo; ?></td>
              </tr>
              <tr>
                <th>Empleado que atendió:</th>
                <td><?php echo $nombreEmpleado; ?></td>
              </tr>
              <tr>
                <th>Placas:</th>
                <td><?php echo $placas; ?></td>
              </tr>
            </table>
            <hr>
            <div class="text-center">
              <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Footer -->
    <div class="mt-1" id="footer-container"></div>

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
