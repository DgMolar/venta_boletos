<?php
require_once "../../utils/conexion_db.php";

// Obtener los datos del formulario
$idViaje = $_POST['id-viaje'];
$idEmpleado = $_POST['id-empleado'];
$nombreCliente = $_POST['nombre'];
$apellidoCliente = $_POST['apellido'];
$correoCliente = $_POST['correo'];
$telefonoCliente = $_POST['telefono'];
$asientoSeleccionado = $_POST['asiento-seleccionado'];
$metodoPago = $_POST['metodo-pago'];
$cantidadPago = $_POST['valor-total'];

// Llamar al procedimiento almacenado
$consulta = "CALL venta_boletos.RealizarVentaConBoleto('$nombreCliente', '$apellidoCliente', '$correoCliente', '$telefonoCliente', $idViaje, $asientoSeleccionado, $idEmpleado, $cantidadPago, $metodoPago)";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
  // Venta realizada correctamente
  $url = "../imprimir_boleto.php?idViaje=$idViaje&asientoSeleccionado=$asientoSeleccionado";
  header("Location: $url");
  exit();
} else {
  // Error en la venta
  echo "Error al realizar la venta: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>
