<?php
require_once "../../utils/conexion_db.php";

// Obtener los valores de idViaje y asientoSeleccionado del query string
$idViaje = $_GET['idViaje'];
$asientoSeleccionado = $_GET['asientoSeleccionado'];

// Consulta SQL para obtener los datos del boleto
$consulta = "SELECT * FROM venta_boletos.vista_boletos WHERE id_viaje = $idViaje AND numero_asiento = $asientoSeleccionado";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado && mysqli_num_rows($resultado) > 0) {
  // Mostrar e imprimir el boleto
  $boleto = mysqli_fetch_assoc($resultado);

  // Aquí puedes utilizar los datos del boleto para generar el PDF o mostrarlos en la página
  // Por ejemplo:
  echo "ID Viaje: " . $boleto['id_viaje'] . "<br>";
  echo "ID Boleto: " . $boleto['id_boleto'] . "<br>";
  echo "Nombre: " . $boleto['nombre'] . "<br>";
  // ... y así sucesivamente

} else {
  // No se encontraron boletos con los parámetros proporcionados
  echo "No se encontraron boletos.";
}

mysqli_close($conexion);
?>
