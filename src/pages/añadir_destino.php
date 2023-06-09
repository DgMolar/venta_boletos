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
    <div class="container border my-5 mx-auto">
      <div class="row justify-content-center my-3">
        <div class="col-6">
        <h1 class="h2 text-center my-4">Bienvenido al registro de destinos</h1>
          <div
            id="formularioContainer"
            class="border p-5">
            <form action="guardar_registro.php" method="POST">
                <div class="form-group">
                  <label for="nombre">Nombre de destino</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Playa del Carmen" required />
                </div>
                <div class="form-group">
                  <label for="direccion">Dirección</label>
                  <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Avenida Landana #345 Lote 12" required />
                </div>
                <div class="form-group">
                  <label for="ciudad">Ciudad</label>
                  <input type="text" class="form-control" id="ciudad" name="ciudad" placeholder="Quintana Roo" required />
                </div>
                <div class="text-center">
                  <button type="submit" class="btn btn-success">Agregar</button>
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
