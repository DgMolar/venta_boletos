<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si se proporcionó el idDestino en el formulario
  if (isset($_POST['idDestino'])) {
    // Obtener los datos del formulario
    $idDestino = $_POST['idDestino'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];

    // Actualizar los datos del destino en la base de datos
    $sql = "UPDATE destinos SET nombre = ?, direccion = ?, ciudad = ? WHERE id_destino = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $direccion, $ciudad, $idDestino);
    
    if ($stmt->execute()) {
      // La actualización se realizó correctamente
      echo '<script>alert("Los cambios se guardaron correctamente."); window.location.href = "../ver_destinos.php";</script>';
    } else {
      // Ocurrió un error durante la actualización
      echo '<script>alert("Error al guardar los cambios."); window.location.href = "../ver_destinos.php";</script>';
    }

    $stmt->close();
  } else {
    echo '<script>alert("No se proporcionó el idDestino en el formulario."); window.location.href = "../ver_destinos.php";</script>';
  }
}
?>
