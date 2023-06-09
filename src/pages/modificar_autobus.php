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
    <title>Modificar Autobuses</title>
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
        <h1>Bienvenido a modificación Autobuses</h1>
        <p>En esta página podrás modificar los detalles de Autobuses</p>
      </div>

      <!-- FORMULARIO DE EDITAR -->
      <form action="./autobuses/modificar_autobus.php" method="POST">
        <?php
        // Verificar si se proporcionó el idAutobus en la URL
        if (isset($_GET['idAutobus'])) {
          // Obtener el idAutobus de la URL
          $idAutobus = $_GET['idAutobus'];

          // Obtener los datos del autobús de la base de datos
          $sql = "SELECT * FROM autobuses WHERE id_autobus = ?";
          $stmt = $conexion->prepare($sql);
          $stmt->bind_param("i", $idAutobus);
          $stmt->execute();
          $result = $stmt->get_result();

          // Verificar si se encontró el autobús
          if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $placa = $row['placa'];
            $modelo = $row['modelo'];
            $estado = $row['estado'];
            $capacidad_asientos = $row['capacidad_asientos'];

            // Mostrar los datos del autobús en los campos del formulario
            ?>
            <div class="form-group">
            <label for="idAutobus">ID Autobús</label>
            <input type="text" class="form-control" id="idAutobus" name="idAutobus" value="<?php echo $idAutobus; ?>" readonly>
          </div>
            <div class="form-group">
              <label for="placa">Placa</label>
              <input type="text" class="form-control" id="placa" name="placa" value="<?php echo $placa; ?>" required>
            </div>
            <div class="form-group">
              <label for="modelo">Modelo</label>
              <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $modelo; ?>" required>
            </div>
            <div class="form-group">
              <label for="estado">Estado</label>
              <select class="form-control" id="estado" name="estado" required>
                <option value="disponible" <?php if ($estado === 'disponible') echo 'selected'; ?>>Disponible</option>
                <option value="no disponible" <?php if ($estado === 'ocupado') echo 'selected'; ?>>Ocupado</option>
              </select>
            </div>
            <div class="form-group">
              <label for="capacidad_asientos">Capacidad de Asientos</label>
              <input type="number" class="form-control" id="capacidad_asientos" name="capacidad_asientos" value="<?php echo $capacidad_asientos; ?>" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary my-2">Guardar cambios</button>
            </div>
        <?php
          } else {
            echo "No se encontró el autobús.";
          }

          $stmt->close();
        } else {
          echo "No se proporcionó el idAutobus en la URL.";
        }
        ?>
      </form>
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
