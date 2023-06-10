<?php
require_once "../../../utils/conexion_db.php";

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el formulario
    $correo = $_POST['email-login'];
    $password = $_POST['password-login'];

    // Consulta SQL para verificar las credenciales del usuario
    $sql = "SELECT * FROM administradores WHERE correo_admin = '$correo' AND password_admin = '$password'";
    $result = $conexion->query($sql);

    // Verifica si se encontró un usuario con las credenciales proporcionadas
    if ($result && $result->num_rows > 0) {
        // Inicio de sesión exitoso
        session_start();
        $_SESSION['correo'] = $correo;
        //alerta de inicio de sesion
        echo "<script>alert('Inicio de sesión exitoso. Redireccionando a la página de inicio...');</script>";
        //redirigir a otra pagina
         header("Location: ../../../pages/inicio.php");
    } else {
        // Credenciales inválidas
        $mensaje = "Credenciales inválidas. Por favor, intenta nuevamente.";
        header("Location: ../../../pages/admin/login.html?mensaje=" . urlencode($mensaje));
    }
}
?>
