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
    <title>Ver Autobuses</title>
    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/navbar/navbar.js"></script>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container"></div>
    <!-- Main content -->
    <div class="container">
      <div class="my-4 text-center">
        <p>
          Hola,
          <?php echo $_SESSION['correo']; ?>
        </p>
        <h1>Bienvenido a ver Autobuses</h1>
        <p>En esta página podrás ver los Autobuses</p>
      </div>
      <div class="row">
        <div class="col">
          <table class="table table-striped table-hover table-bordered">
            <thead class="thead-dark">
              <tr>
                <th scope="col">ID Autobus</th>
                <th scope="col">Placa</th>
                <th scope="col">Modelo</th>
                <th scope="col">Estado</th>
                <th scope="col">Capacidad</th>
                <th scope="col">Acción</th>
              </tr>
            </thead>
            <tbody id="tablaResultados" class="text-center"></tbody>
          </table>
        </div>
      </div>
      <!-- FORMULARIO -->
      <div class="text-center">
      <button id="btnMostrarFormulario" class="btn btn-primary my-3">
        <a href="añadir_autobus.php" style="color: white; text-decoration: none;">
          Añadir nuevo
        </a>
      </button>
      </div>
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE JS-->
    <script type="module" src="./autobuses/ver_autobuses.js"></script>

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
