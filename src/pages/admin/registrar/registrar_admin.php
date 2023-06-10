<?php
require_once "../../../utils/conexion_db.php";

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el formulario
    $nombreAdministrador = $_POST['nombre-administrador'];
    $apellidoAdministrador = $_POST['apellido-administrador'];
    $correoAdministrador = $_POST['email-register'];
    $contrasenaAdministrador = $_POST['password-first'];

    // Consulta SQL para insertar los datos en la tabla "administradores"
    $sql = "INSERT INTO administradores (nombre_admin, apellido_admin, correo_admin, password_admin) 
            VALUES ('$nombreAdministrador', '$apellidoAdministrador', '$correoAdministrador', '$contrasenaAdministrador')";

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
