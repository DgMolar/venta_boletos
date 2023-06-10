<?php
require_once "../../utils/conexion_db.php";
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['correo'])) {
  // Si no hay sesión iniciada, redirigir al usuario al formulario de inicio de sesión
  header("Location: ./admin/login.html");
  exit; // Terminar el script para evitar que se siga ejecutando
}

// Si hay sesión iniciada, puedes acceder a $_SESSION['correo'] para obtener el correo del usuario
$correoUsuario = $_SESSION['correo'];

// Ejecuta la consulta SQL para obtener los puestos
$query = "SELECT id_puesto, nombre_puesto FROM puestos;";
$result = $conexion->query($query);
$puestos = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $puestos[$row['id_puesto']] = $row['nombre_puesto'];
  }
} else {
  echo "No se encontraron puestos.";
}
$conexion->close();
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
    <title>Registrar</title>
  </head>

  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <h1 class="navbar-brand text-center mx-auto" style="font-size: 40px">
          REGISTRO DE ADMINISTRADORES
        </h1>
      </div>
    </nav>

    <!-- Registrar -->
    <div class="container my-5">
      <div class="row bg-light">
        <div class="col-md-1 text-center pt-3">
          <a href="inicio.php"
            ><i class="bi bi-house-door text-dark"> INICIO </i></a
          >
        </div>
        <div class="col-md-11 mb-3 p-5">
          <div class="card">
            <div class="card-header text-dark text-center">
              <h4>Registrar:</h4>
            </div>
            <div class="card-body">
              <!--FORMULARIO-->
              <form id="register-form" action="registrar/registrar_admin.php" method="post">
                <!--NOMBRE DE ADMINISTRADOR-->
                <div class="form-group text-secondary">
                  <label for="nombre-administrador">Nombre de administrador:</label>
                  <input type="text" class="form-control" id="nombre-administrador" name="nombre-administrador" placeholder="Juan" required />
                </div>
                <!--APELLIDO DE ADMINISTRADOR-->
                <div class="form-group text-secondary">
                  <label for="apellido-administrador">Apellido de administrador:</label>
                  <input type="text" class="form-control" id="apellido-administrador" name="apellido-administrador" placeholder="Pérez" required />
                </div>
                <!--CORREO ELECTRÓNICO-->
                <div class="form-group text-secondary">
                  <label for="email">Correo electrónico:</label>
                  <input type="email" class="form-control" id="email-register" name="email-register" placeholder="user@gmail.com" required />
                </div>
                <!--CONTRASEÑA-->
                <div class="form-group text-secondary">
                  <label for="password">Contraseña:</label>
                  <input type="password" class="form-control" id="password-first" name="password-first" placeholder="Contraseña" required />
                </div>
                <!--CONFIRMAR CONTRASEÑA-->
                <div class="form-group text-secondary">
                  <label for="password">Confirme Contraseña:</label>
                  <input type="password" class="form-control" id="password-confirm" name="password-confirm" placeholder="Contraseña" required />
                </div>
                <div id="validationErrors" class="container text-danger text-center"></div>
                <!--BOTON SUBMIT-->
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-primary mt-4">Registrar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
      <p>© 2023 Venta de Boletos de Autobús. Todos los derechos reservados.</p>
    </footer>

    <script type="module" src="registrar/registrar_admin.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>