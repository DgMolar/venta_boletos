<?php
require_once "../../utils/conexion_db.php";

// Ejecuta la consulta SQL
$query = "SELECT * FROM destinos;";
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
