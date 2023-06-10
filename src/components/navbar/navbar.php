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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="inicio.php">
    <img
      class="border border-info rounded"
      src="../images/logo.jpg"
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
        <a class="nav-link btn btn-info px-4 mx-1 btn-lg" href="inicio.php"
          >Inicio</a
        >
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-info px-4 mx-1 btn-lg" href="boletos.php"
          >Boletos</a
        >
      </li>
      <li class="nav-item">
        <a class="nav-link btn btn-info px-4 mx-1 btn-lg" href="ventas.php"
          >Ventas</a
        >
      </li>
      <li class="nav-item dropdown">
        <a
          class="nav-link dropdown-toggle btn btn-info px-4 mx-1 btn-lg"
          href="#"
          id="navbarDropdownReports"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Viajes
        </a>
        <div class="dropdown-menu text-center" aria-labelledby="navbarDropdownReports">
          <a class="dropdown-item" href="./ver_viajes.php">Ver Viajes</a>
          <a class="dropdown-item" href="./ver_destinos.php">Ver Destinos</a>
          <a class="dropdown-item" href="./ver_autobuses.php">Ver Autobuses</a>
        </div>
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
          <a class="dropdown-item" href="./auth/logout.php">Cerrar Sesión</a>
        </div>
      </li>
    </ul>
  </div>
</nav>
<script type="module" src="./navbar_events.js"></script>
