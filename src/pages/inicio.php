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
    <title>Venta de Boletos de Autobús</title>
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
      <!-- Búsqueda de viajes -->
      <div id="buscar-viajes" class="my-4">
        <h2>Buscar Viajes</h2>
        <form id="buscar-viajes-form">
          <div class="form-group">
            <label for="destino">Destino:</label>
            <input
              type="text"
              class="form-control"
              id="destino"
              name="destino"
              placeholder="Ingrese el destino"
            />
          </div>
          <button id="buscar-viajes-btn" type="submit" class="btn btn-primary">
            Buscar destino
          </button>
        </form>
      </div>
      <!-- fin  Búsqueda de viajes-->

      <!-- Viajes encontrados -->
      <div id="viajes-encontrados" class="my-4">
        <h2>Viajes Encontrados</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Viaje</th>
              <th>Nombre</th>
              <th>Dirección</th>
              <th>Ciudad</th>
              <th>Fecha Salida</th>
              <th>Costo</th>
              <th>Capacidad Asientos</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody id="resultados-body">
            <!-- Aquí se imprimirán los resultados -->
          </tbody>
        </table>
      </div>
      <!-- FIN  Viajes encontrados -->
      <!-- Formulario completo -->
      <div id="formulario-completo" class="my-4 border py-3 px-5 d-none">
        <h2>Formulario Completo</h2>
        <form id="formulario-completo-form">
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
              />
            </div>
            <div class="form-group">
              <label for="telefono">Teléfono:</label>
              <input
                type="tel"
                class="form-control"
                id="telefono"
                name="telefono"
                placeholder="Ingrese su número de teléfono"
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
            />
          </div>

          <!-- Total a pagar y método de pago -->
          <div id="pago" class="my-4">
            <h3>Pago</h3>
            <div id="total-pagar"></div>
            <label for="total-pago"
              ><h5>Total a Pagar:</h5>
              $</label
            >
            <div class="form-group">
              <label for="metodo-pago">Método de Pago:</label>
              <select class="form-control" id="metodo-pago" name="metodo-pago">
                <option value="efectivo">Efectivo</option>
                <option value="tarjeta">Tarjeta de Crédito</option>
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
    <script type="module" src="./vender_boletos/venta_boletos.js"></script>
    <script type="module" src="./vender_boletos/vender.js"></script>
    <!--SCRIPTS DE footer-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
