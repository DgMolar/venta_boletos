<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  // Verificar si se proporcionó el idAutobus en la URL
  if (isset($_GET['idAutobus'])) {
    // Obtener el idAutobus de la URL
    $idAutobus = $_GET['idAutobus'];

    // Verificar si el autobús está asociado a algún viaje en la tabla "viajes"
    $sqlVerificacion = "SELECT * FROM viajes WHERE id_autobus = ?";
    $stmtVerificacion = $conexion->prepare($sqlVerificacion);
    $stmtVerificacion->bind_param("i", $idAutobus);
    $stmtVerificacion->execute();
    $result = $stmtVerificacion->get_result();

    if ($result->num_rows > 0) {
      // El autobús está asociado a al menos un viaje en la tabla "viajes"
      echo '<script>alert("No se puede eliminar el autobús porque fué asociado a uno o más viajes."); window.location.href = "../ver_autobuses.php";</script>';
    } else {
      // No hay viajes asociados al autobús, se puede proceder con la eliminación

      // Eliminar el autobús de la base de datos
      $sqlEliminacion = "DELETE FROM autobuses WHERE id_autobus = ?";
      $stmtEliminacion = $conexion->prepare($sqlEliminacion);
      $stmtEliminacion->bind_param("i", $idAutobus);

      if ($stmtEliminacion->execute()) {
        // La eliminación se realizó correctamente
        echo '<script>alert("El autobús se eliminó correctamente."); window.location.href = "../ver_autobuses.php";</script>';
      } else {
        // Ocurrió un error durante la eliminación
        echo '<script>alert("Error al eliminar el autobús."); window.location.href = "../ver_autobuses.php";</script>';
      }

      $stmtEliminacion->close();
    }

    $stmtVerificacion->close();
  } else {
    echo '<script>alert("No se proporcionó el idAutobus en la URL."); window.location.href = "../ver_autobuses.php";</script>';
  }
}
?>