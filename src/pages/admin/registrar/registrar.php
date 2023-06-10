<?php
require_once "../../../utils/conexion_db.php";

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el formulario
    $nombreEmpleado = $_POST['nombre-empleado'];
    $apellidoEmpleado = $_POST['apellido-empleado'];
    $correoEmpleado = $_POST['email-register'];
    $contrasenaEmpleado = $_POST['password-first'];
    $idPuesto = $_POST['puesto'];

    // Consulta SQL para insertar los datos en la tabla "empleados"
    $sql = "INSERT INTO empleados (nombre_empleado, apellido_empleado, correo_empleado, contrasena_empleado, id_puesto) 
            VALUES ('$nombreEmpleado', '$apellidoEmpleado', '$correoEmpleado', '$contrasenaEmpleado', '$idPuesto')";

    // Ejecuta la consulta SQL
    if ($conexion->query($sql) === TRUE) {
        // Insert exitoso
        echo "<script>alert('¡El formulario se ha enviado correctamente!');</script>";
        // Aquí puedes agregar código adicional si deseas realizar alguna acción después de enviar el formulario

        // Redirigir a otra página
        header("Location: ../inicio.php");
    } else {
        // Error en la consulta SQL
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>
