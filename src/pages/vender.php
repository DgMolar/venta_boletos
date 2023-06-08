<?php
session_start();

require_once "../utils/conexion_db.php";

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
  // Si no hay sesión iniciada, redirigir al usuario al formulario de inicio de sesión
  header("Location: ./auth/login.html");
  exit; // Terminar el script para evitar que se siga ejecutando
}

// Si hay sesión iniciada, puedes acceder a $_SESSION['correo'] para obtener el correo del usuario
$correoUsuario = $_SESSION['correo'];
// Realizar una consulta para obtener el id_empleado
$sql = "SELECT id_empleado FROM empleados WHERE correo_empleado = '$correoUsuario'";
$resultado = mysqli_query($conexion, $sql);

if ($resultado && mysqli_num_rows($resultado) > 0) { 
  // Obtener el id_empleado.
  $fila = mysqli_fetch_assoc($resultado);
$idEmpleado = $fila['id_empleado']; // Hacer lo que necesites con el id_empleado
} ?>
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
    <title>Vender</title>
    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/navbar/navbar.js"></script>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container"></div>

    <!-- Main content -->
    <div class="container my-4 text-center">
      <h1>Bienvenido a la venta de boletos de autobús</h1>
      <!-- Aquí puedes agregar el contenido principal de tu aplicación -->
      <p>
        Hola,
        <?php echo $_SESSION['correo']; ?>
      </p>
      <!-- Formulario completo -->
      <div id="formulario-completo" class="my-4 border py-3 px-5">
        <h2>REALIZAR VENTA</h2>
        <form id="formulario-completo-form" action="./vender_boletos/generar_venta.php" method="POST">
          <!-- ID del viaje y empleado -->
          <div id="datos-viaje" class="my-4">
            <h3>Datos del Viaje</h3>
            <div class="form-group">
              <label for="id-viaje">ID del Viaje:</label>
              <input
                type="number"
                class="form-control"
                id="input-id-viaje"
                name="id-viaje"
                value=""
                readonly
                required
              />
            </div>
            <div class="form-group">
              <label for="id-empleado">ID del Empleado:</label>
              <input
                type="number"
                class="form-control"
                id="id-empleado"
                name="id-empleado"
                value="<?php echo $idEmpleado; ?>"
                readonly
                required
              />
            </div>
          <!-- Datos del cliente -->
          <div id="datos-cliente" class="my-4">
            <h3>Datos del Cliente</h3>
            <div class="form-group">
              <label for="nombre">Nombre:</label>
              <input
                type="text"
                class="form-control"
                id="nombre"
                name="nombre"
                placeholder="Ingrese su nombre"
                required
              />
            </div>
            <div class="form-group">
              <label for="apellido">Apellido:</label>
              <input
                type="text"
                class="form-control"
                id="apellido"
                name="apellido"
                placeholder="Ingrese su apellido"
                required
              />
            </div>
            <div class="form-group">
              <label for="correo">Correo:</label>
              <input
                type="email"
                class="form-control"
                id="correo"
                name="correo"
                placeholder="Ingrese su correo electrónico"
                required
              />
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono:</label>
              <input
                type="tel"
                class="form-control"
                id="telefono"
                name="telefono"
                pattern="[0-9]{10}"
                placeholder="Ingrese su número de teléfono a 10 dígitos- Ej. 1234567890"
                required
              />
            </div>
          </div>

          <!-- Selección de asientos -->
          <div id="seleccion-asientos" class="my-4">
            <h3>Seleccionar Asientos</h3>
            <div id="lista-asientos"></div>
            <label for="asiento-seleccionado">Asiento seleccionado:</label>
            <input
              type="number"
              class="form-control"
              id="asiento-seleccionado"
              name="asiento-seleccionado"
              placeholder="Ingrese la Asiento seleccionado"
              required
            />
          </div>

          <!-- Total a pagar y método de pago -->
          <div id="pago" class="my-4">
            <h3>Pago</h3>
            <div id="total-pagar"></div>
              <label for="valor-total">Total a Pagar:</label>
              <input
                type="number"
                class="form-control"
                id="valor-total"
                name="valor-total"
                value=""
                readonly
              />
            <div class="form-group">
              <label for="metodo-pago">Método de Pago:</label>
              <select class="form-control" id="metodo-pago" name="metodo-pago">
                <option value="1" selected>Efectivo</option>
                <option value="2">Tarjeta de Crédito</option>
                <option value="3">Tarjeta de Debito</option>
              </select>
            </div>
            <div class="form-group">
              <label for="cantidad-pago">Cantidad Pagada:</label>
              <input
                type="number"
                class="form-control"
                id="cantidad-pago"
                name="cantidad-pago"
                placeholder="Ingrese la cantidad pagada"
                required
              />
            </div>
            <div class="form-group">
              <label for="cambio-pago">Cambio:</label>
              <input
                type="number"
                class="form-control"
                id="cambio-pago"
                name="cambio-pago"
                readonly
              />
            </div>
          </div>

          <button type="submit" class="btn btn-primary">Finalizar Venta</button>
        </form>
      </div>
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE venta_boletos.js-->
    <script type="module" src="./vender_boletos/vender.js"></script>
    <!--SCRIPTS DE footer-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
