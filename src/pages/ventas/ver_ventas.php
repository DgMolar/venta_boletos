<?php
require_once "../../utils/conexion_db.php";

// Obtener las fechas proporcionadas como parámetros
$fechaInicio = $_GET['fechaInicio'];
$fechaFin = $_GET['fechaFin'];

// Obtener el parámetro de ordenamiento
$ordenamiento = $_GET['ordenamiento'];

// Escapar las variables para evitar inyección de SQL
$fechaInicio = $conexion->real_escape_string($fechaInicio);
$fechaFin = $conexion->real_escape_string($fechaFin);
$ordenamiento = $conexion->real_escape_string($ordenamiento);

// Construir la consulta SQL con la cláusula WHERE y ORDER BY
$query = "CALL venta_boletos.obtenerInformacionVentas('$fechaInicio', '$fechaFin', '$ordenamiento');";
$result = $conexion->query($query);

// Verifica si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Crea un objeto para almacenar los datos
    $datos = new stdClass();

    // Crea una propiedad "resultados" y almacena los datos como un array en esa propiedad
    $datos->resultados = array();

    // Itera sobre los resultados y almacena cada fila en el array de resultados
    while ($row = $result->fetch_assoc()) {
        $datos->resultados[] = $row;
    }

    // Convierte el objeto a formato JSON y lo imprime
    echo json_encode($datos);
} else {
    echo "No se encontraron resultados.";
}

// Cierra la conexión a la base de datos
$conexion->close();
?>
