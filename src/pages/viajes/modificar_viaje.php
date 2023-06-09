<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Verificar si se proporcionó el idViaje en el formulario
  if (isset($_POST['id_viaje'])) {
    // Obtener los datos del formulario
    $idViaje = $_POST['id_viaje'];
    $idDestino = $_POST['id_destino'];
    $fechaSalida = $_POST['fecha_salida'];
    $fechaLlegada = $_POST['fecha_llegada'];
    $estadoViaje = $_POST['estado_viaje'];
    $costo = $_POST['costo'];
    $idAutobus = $_POST['id_autobus'];

    // Actualizar los datos del viaje en la base de datos
    $sql = "UPDATE viajes SET id_destino = ?, fecha_salida = ?, fecha_llegada = ?, estado_viaje = ?, costo = ?, id_autobus = ? WHERE id_viaje = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("iisssdi", $idDestino, $fechaSalida, $fechaLlegada, $estadoViaje, $costo, $idAutobus, $idViaje);
    
    if ($stmt->execute()) {
      // La actualización se realizó correctamente
      echo '<script>alert("Los cambios se guardaron correctamente."); window.location.href = "../ver_viajes.php";</script>';
    } else {
      // Ocurrió un error durante la actualización
      echo '<script>alert("Error al guardar los cambios."); window.location.href = "../ver_viajes.php";</script>';
    }

    $stmt->close();
  } else {
    echo '<script>alert("No se proporcionó el idViaje en el formulario."); window.location.href = "../ver_viajes.php";</script>';
  }
}
?>
