<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtener los valores del formulario
  $nombre = $_POST["nombre"];
  $direccion = $_POST["direccion"];
  $ciudad = $_POST["ciudad"];

  // Preparar la consulta SQL con marcadores de posición (?)
  $sql = "INSERT INTO destinos (nombre, direccion, ciudad) VALUES (?, ?, ?)";
  $stmt = $conexion->prepare($sql);

  // Vincular los parámetros a los marcadores de posición
  $stmt->bind_param("sss", $nombre, $direccion, $ciudad);

  // Ejecutar la consulta
  if ($stmt->execute()) {
    // La inserción se realizó correctamente
    echo '<script>alert("El destino se ha añadido correctamente.");</script>';
    // Redireccionar a otra página después de 3 segundos
    echo '<script>setTimeout(function() { window.location.href = "../ver_destinos.php"; }, 100);</script>';
  } else {
    // Ocurrió un error durante la inserción
    echo "Error al añadir el destino: " . $stmt->error;
  }

  // Cerrar la consulta y la conexión
  $stmt->close();
  $conexion->close();
}
?>