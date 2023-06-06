<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "venta_boletos";
$port = 3306;

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error al conectar a la base de datos: " . $conexion->connect_error);
}
?>
