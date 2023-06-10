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
// Consulta SQL para obtener los datos de la tabla "vista_boletos"
$sql = "SELECT * FROM vista_boletos";
$resultado = $conexion->query($sql);
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
    <title>Inicio Administración</title>
  </head>

  <body>
    <!-- Navbar -->
    <div id="navbar-container">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="inicio.php">
          <img
            class="border border-info rounded"
            src="../../images/logo.jpg"
            alt="Logo"
            height="200"
          />
        </a>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav mx-auto">
            <li class="nav-item active">
              <a
                class="nav-link btn btn-info px-4 mx-1 btn-lg"
                href="inicio.php"
                >Inicio</a
              >
            </li>
            <li class="nav-item active">
              <a
                class="nav-link btn btn-info px-4 mx-1 btn-lg"
                href="registrar.php"
                >Registrar empleados</a
              >
            </li>
            <li class="nav-item active">
              <a
                class="nav-link btn btn-info px-4 mx-1 btn-lg"
                href="registrar_admin.php"
                >Registrar administrador</a
              >
            </li>
          </ul>
          <ul class="navbar-nav btn btn-outline-info p-0">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdownProfile"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <i class="bi bi-person-circle h4"></i>
                <?php echo $_SESSION['correo']; ?>
              </a>
              <div
                class="dropdown-menu dropdown-menu-right"
                aria-labelledby="navbarDropdownProfile"
              >
                <a class="dropdown-item" href=".../../../auth/logout.php"
                  >Cerrar Sesión</a
                >
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </div>

    <!-- Main content -->
    <div class="container my-4 text-center">
      <h1>Bienvenido a la pagina de Administración</h1>
      <!-- Aquí puedes agregar el contenido principal de tu aplicación -->
      <p>
        Hola,
        <?php echo $_SESSION['correo']; ?>
      </p>
      <!-- contenido de boletos-->
      <div class="container my-4">
        <h2>Boletos</h2>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID Boleto</th>
              <th>ID Viaje</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Fecha Salida</th>
              <th>Destino</th>
              <th>Número Asiento</th>
              <th>Costo</th>
              <th>Nombre Empleado</th>
              <th>Placa</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $resultado->fetch_assoc()) { ?>
              <tr>
                <td><?php echo $row['id_boleto']; ?></td>
                <td><?php echo $row['id_viaje']; ?></td>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['apellido']; ?></td>
                <td><?php echo $row['fecha_salida']; ?></td>
                <td><?php echo $row['destino']; ?></td>
                <td><?php echo $row['numero_asiento']; ?></td>
                <td><?php echo $row['costo']; ?></td>
                <td><?php echo $row['nombre_empleado']; ?></td>
                <td><?php echo $row['placa']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
        <hr>
        <div class="text-center">
          <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
        </div>
      </div>
    </div>





    <!-- Footer -->
    <div id="footer-container">
      <!-- Footer -->
      <footer class="bg-dark text-white text-center py-3">
        <p>
          © 2023 Central de Autobuses Ositos Viajeros. Todos los derechos
          reservados.
        </p>
      </footer>
    </div>

    <!--SCRIPTS DE venta_boletos.js-->
    <!-- <script type="module" src="./vender_boletos/venta_boletos.js"></script> -->
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
