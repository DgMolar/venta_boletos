<?php
require_once "../../utils/conexion_db.php";
// Obtener el parámetro idViaje de la solicitud POST
$data = json_decode(file_get_contents("php://input"), true);
$idViaje = $data['idViaje'];

// Ejecutar el procedimiento almacenado ObtenerAsientosOcupados y obtener los datos
$sqlAsientosOcupados = "CALL venta_boletos.ObtenerAsientosOcupados('$idViaje')";
$resultadoAsientosOcupados = mysqli_query($conexion, $sqlAsientosOcupados);

// Verificar si la consulta se ejecutó correctamente y si se obtuvieron resultados
if ($resultadoAsientosOcupados && mysqli_num_rows($resultadoAsientosOcupados) > 0) {
    // Crear un array para almacenar los asientos ocupados
    $asientosOcupados = array();

    // Obtener los resultados y almacenarlos en el array
    while ($fila = mysqli_fetch_assoc($resultadoAsientosOcupados)) {
        $asientosOcupados[] = $fila;
    }

    // Obtener la capacidad de asientos
    $capacidadAsientos = $asientosOcupados[0]['capacidad_asientos'];
} else {
    // Ejecutar el procedimiento almacenado CapacidadBusViaje y obtener los datos
    $sqlCapacidadBusViaje = "CALL venta_boletos.CapacidadBusViaje('$idViaje')";
    $resultadoCapacidadBusViaje = mysqli_query($conexion, $sqlCapacidadBusViaje);

    // Verificar si la consulta se ejecutó correctamente y si se obtuvieron resultados
    if ($resultadoCapacidadBusViaje && mysqli_num_rows($resultadoCapacidadBusViaje) > 0) {
        // Obtener el resultado de la capacidad de asientos
        $filaCapacidadBusViaje = mysqli_fetch_assoc($resultadoCapacidadBusViaje);
        $capacidadAsientos = $filaCapacidadBusViaje['capacidad_asientos'];

        // Establecer asientosOcupados como null
        $asientosOcupados = null;
    } else {
        // Imprimir mensaje de error si la consulta falló o no se obtuvieron resultados
        echo "Error en la consulta o no se encontraron resultados.";
        exit;
    }
}

// Crear un array con los datos
$response = array(
    'totalAsientos' => $capacidadAsientos,
    'asientosOcupados' => $asientosOcupados
);

// Devolver la respuesta como JSON
echo json_encode($response);
?>
