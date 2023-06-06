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
      <!-- Otro contenido específico para usuarios autenticados -->
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
