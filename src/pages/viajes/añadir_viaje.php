<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obtener los valores del formulario
  $idDestino = $_POST['id_destino'];
  $fechaSalida = $_POST['fecha_salida'];
  $fechaLlegada = $_POST['fecha_llegada'];
  $costo = $_POST['costo'];
  $idAutobus = $_POST['id_autobus'];

  // Insertar los datos del viaje en la base de datos
  $sql = "INSERT INTO viajes (id_destino, fecha_salida, fecha_llegada, costo, id_autobus) VALUES (?, ?, ?, ?, ?)";
  $stmt = $conexion->prepare($sql);
  $stmt->bind_param("issdi", $idDestino, $fechaSalida, $fechaLlegada, $costo, $idAutobus);
  
  if ($stmt->execute()) {
    // La inserción se realizó correctamente
    echo '<script>alert("El viaje se ha añadido correctamente."); window.location.href = "../ver_viajes.php";</script>';
  } else {
    // Ocurrió un error durante la inserción
    echo '<script>alert("Error al añadir el viaje."); window.location.href = "../ver_viajes.php";</script>';
  }

  $stmt->close();
}
?>
