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
    <title>Ver Destino</title>
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
          Hola, <?php echo $_SESSION['correo']; ?>
        </p>
        <h1>Bienvenido a ver Destinos</h1>
        <p>En esta página podrás ver los viajes</p>
      </div>
      <!-- Formulario editar destinos -->
      <?php
      // Verificar si se proporcionó el idDestino en la URL
      if (isset($_GET['idDestino'])) {
        // Obtener el idDestino de la URL
        $idDestino = $_GET['idDestino'];

        // Obtener los datos del destino de la base de datos
        $sql = "SELECT * FROM destinos WHERE id_destino = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $idDestino);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si se encontró el destino
        if ($result->num_rows === 1) {
          $row = $result->fetch_assoc();
          $nombre = $row['nombre'];
          $direccion = $row['direccion'];
          $ciudad = $row['ciudad'];

          // Mostrar los datos del destino en los campos del formulario
          ?>
          <form action="./destinos/modificar_destino.php" method="POST">
            <div class="form-group">
              <label for="idDestino">ID Destino</label>
              <input type="text" class="form-control" id="idDestino" name="idDestino" value="<?php echo $idDestino; ?>" readonly>
            </div>
            <div class="form-group">
              <label for="nombre">Nombre de destino</label>
              <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>
            </div>
            <div class="form-group">
              <label for="direccion">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion; ?>" required>
            </div>
            <div class="form-group">
              <label for="ciudad">Ciudad</label>
              <input type="text" class="form-control" id="ciudad" name="ciudad" value="<?php echo $ciudad; ?>" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary my-4">Guardar cambios</button>
            </div>
          </form>
        <?php
        } else {
          echo "No se encontró el destino.";
        }

        $stmt->close();
      } else {
        echo "No se proporcionó el idDestino en la URL.";
      }
      ?>
    </div>

    <!-- Footer -->
    <div id="footer-container"></div>

    <!--SCRIPTS DE JS-->
    <script type="module" src="./destinos/ver_destinos.js"></script>

    <!--SCRIPTS DE Navbar-->
    <script type="module" src="../components/footer/footer.js"></script>
    <!--SCRIPTS DE LIBRERIAS-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  </body>
</html>
