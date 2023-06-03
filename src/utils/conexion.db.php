<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "venta_boletos";
$port = 3306;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error al conectar a la base de datos: " . $conn->connect_error);
}else{
    echo "Conexión exitosa";
}

// Aquí puedes realizar consultas y operaciones en la base de datos

// Cerrar la conexión
$conn->close();
?>
