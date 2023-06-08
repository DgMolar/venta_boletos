<?php
require_once "../../utils/conexion_db.php";
// Obtener el parámetro idViaje de la solicitud POST
$data = json_decode(file_get_contents("php://input"), true);
$idViaje = $data['idViaje'];
// $idViaje = 4;
// Ejecutar el procedimiento almacenado y obtener los datos
$sql = "CALL venta_boletos.ObtenerAsientosOcupados('$idViaje')";
$resultado = mysqli_query($conexion, $sql);

// Verificar si la consulta se ejecutó correctamente
if ($resultado) {
    // Verificar si se obtuvieron resultados
    if (mysqli_num_rows($resultado) > 0) {
        // Crear un array para almacenar los asientos ocupados
        $asientosOcupados = array();

        // Obtener los resultados y almacenarlos en el array
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $asientosOcupados[] = $fila;
        }

        // Obtener la capacidad de asientos
        $capacidadAsientos = $asientosOcupados[0]['capacidad_asientos'];

        // Crear un array con los datos
        $response = array(
            'totalAsientos' => $capacidadAsientos,
            'asientosOcupados' => $asientosOcupados
        );
    } else {
        $asientosOcupados = array();
        // Obtener los resultados y almacenarlos en el array
        while ($fila = 0) {
            $asientosOcupados[] = $fila;
        }
        $capacidadAsientos = "";
        // No hay registros
        $response = array(
            'totalAsientos' => $capacidadAsientos,
            'asientosOcupados' => $asientosOcupados
        );
        // echo json_encode($response);
    }
    // Devolver la respuesta como JSON
    echo json_encode($response);
} else {
    // Imprimir mensaje de error si la consulta falló
    echo "Error en la consulta: " . mysqli_error($conexion);
}
?>