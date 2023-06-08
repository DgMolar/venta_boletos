<?php
require_once "../../utils/conexion_db.php";

// $idViaje = $_POST['idViaje'];
$idViaje = 4;

$sql = "CALL venta_boletos.AsientosDisponiblesViaje('$idViaje')";
$resultado = mysqli_query($conexion, $sql);

if ($resultado) {
  if (mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $asientosDisponibles = $fila['asientos_disponibles'];
    $capacidadAsientos = $fila['capacidad_asientos'];

    $response = array(
      'capacidadAsientos' => $capacidadAsientos,
      'asientosOcupados' => array()
    );
  } else {
    echo "No hay registros";
    $asientosDisponibles = "";
    $capacidadAsientos = "";
    $response = array(
      'capacidadAsientos' => $capacidadAsientos,
      'asientosOcupados' => array()
    );
  }

  echo json_encode($response);
} else {
  echo "Error en la consulta: " . mysqli_error($conexion);
}
?>
