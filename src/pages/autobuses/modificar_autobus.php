<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si se proporcionó el idAutobus en el formulario
  if (isset($_POST['idAutobus'])) {
    // Obtener los datos del formulario
    $idAutobus = $_POST['idAutobus'];
    $placa = $_POST['placa'];
    $modelo = $_POST['modelo'];
    $estado = $_POST['estado'];
    $capacidad_asientos = $_POST['capacidad_asientos'];

    // Actualizar los datos del autobús en la base de datos
    $sql = "UPDATE autobuses SET placa = ?, modelo = ?, estado = ?, capacidad_asientos = ? WHERE id_autobus = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssii", $placa, $modelo, $estado, $capacidad_asientos, $idAutobus);
    
    if ($stmt->execute()) {
      // La actualización se realizó correctamente
      echo '<script>alert("Los cambios se guardaron correctamente."); window.location.href = "../ver_autobuses.php";</script>';
    } else {
      // Ocurrió un error durante la actualización
      echo '<script>alert("Error al guardar los cambios."); window.location.href = "../ver_autobuses.php";</script>';
    }

    $stmt->close();
  } else {
    echo '<script>alert("No se proporcionó el idAutobus en el formulario."); window.location.href = "../ver_autobuses.php";</script>';
  }
}
?>
