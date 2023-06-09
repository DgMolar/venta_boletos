<?php
require_once "../../utils/conexion_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  // Obtener los valores del formulario
  $placa = $_POST["placa"];
  $modelo = $_POST["modelo"];
  $estado = $_POST["estado"];
  $capacidad_asientos = $_POST["capacidad_asientos"];

  // Preparar la consulta SQL con los valores directamente
  $sql = "INSERT INTO autobuses (placa, modelo, estado, capacidad_asientos) VALUES ('$placa', '$modelo', '$estado', $capacidad_asientos)";

  // Ejecutar la consulta
  if ($conexion->query($sql) === TRUE) {
    // La inserción se realizó correctamente
    echo '<script>alert("El autobús se ha añadido correctamente.");</script>';
    // Redireccionar a otra página después de 3 segundos
    echo '<script>setTimeout(function() { window.location.href = "../ver_autobuses.php"; }, 500);</script>';
  } else {
    // Ocurrió un error durante la inserción
    echo "Error al añadir el autobús: " . $conexion->error;
  }

  // Cerrar la conexión
  $conexion->close();
}
?>
