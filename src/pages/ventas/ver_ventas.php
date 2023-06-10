<?php
require_once "../../utils/conexion_db.php";

// Obtener las fechas proporcionadas como parámetros
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];

// Escapar las variables para evitar inyección de SQL
$fechaInicio = $conexion->real_escape_string($fechaInicio);
$fechaFin = $conexion->real_escape_string($fechaFin);

// Construir la consulta SQL para obtener el total de ventas
$queryTotalVentas = "SELECT venta_boletos.CalcularTotalVentas('$fechaInicio', '$fechaFin') AS totalVentas";
$resultTotalVentas = $conexion->query($queryTotalVentas);

// Verificar si se obtuvo el resultado
if ($resultTotalVentas) {
    $rowTotalVentas = $resultTotalVentas->fetch_assoc();
    $totalVentas = $rowTotalVentas['totalVentas'];

    // Construir el objeto JSON para devolver los resultados
    $datos = new stdClass();
    $datos->totalVentas = $totalVentas;

    // Obtener los resultados de las ventas
    $queryVentas = "CALL venta_boletos.obtenerInformacionVentas('$fechaInicio', '$fechaFin', '')";
    $resultVentas = $conexion->query($queryVentas);

    // Verificar si se obtuvieron resultados de las ventas
    if ($resultVentas->num_rows > 0) {
        $datos->resultados = array();

        // Iterar sobre los resultados y almacenar cada fila en el array de resultados
        while ($rowVentas = $resultVentas->fetch_assoc()) {
            $datos->resultados[] = $rowVentas;
        }
    } else {
        // No se encontraron resultados de ventas
        $datos->resultados = array();
    }

    // Convertir el objeto a formato JSON y devolverlo
    echo json_encode($datos);
} else {
    // Error en la consulta SQL del total de ventas
    echo "Error al obtener el total de ventas.";
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
