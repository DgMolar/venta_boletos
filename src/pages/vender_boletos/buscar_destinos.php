<?php
require_once "../../utils/conexion_db.php";

// Obtener el destino enviado desde la solicitud AJAX o formulario
$destino = $_GET['destino'];

// Llamar al procedimiento almacenado para buscar las ventas por destino
$sql = "CALL venta_boletos.BuscarViajePorDestino('$destino')";
$result = $conexion->query($sql);

// Obtener los resultados del procedimiento
$viajes = array();
if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $viajes[] = $row;
  }
}

// // Devolver los resultados como JSON
header('Content-Type: application/json');
echo json_encode($viajes);

// Cerrar la conexión a la base de datos
$conexion->close();
?>
