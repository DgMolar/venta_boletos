<?php
require_once "../../../utils/conexion_db.php";

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el formulario
    $correo = $_POST['email-login'];
    $password = $_POST['password-login'];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM empleados WHERE correo_empleado = '$correo' AND contrasena_empleado = '$password'";
    $result = $conexion->query($sql);

    // Verifica si se encontró un usuario con las credenciales proporcionadas
    if ($result && $result->num_rows > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['correo'] = $correo;
        echo "Inicio de sesión exitoso. Redireccionando a la página de inicio...";
        //redirigir a otra pagina
         header("Location: ../../../pages/inicio.php");
    } else {
        // Credenciales inválidas
        $mensaje = "Credenciales inválidas. Por favor, intenta nuevamente.";
        header("Location: ../../../pages/auth/login.html?mensaje=" . urlencode($mensaje));
    }
}
?>
