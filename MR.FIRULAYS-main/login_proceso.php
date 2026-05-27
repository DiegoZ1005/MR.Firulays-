<?php
include 'conexion.php';
session_start();

// Limpiamos los datos para evitar inyecciones básicas
$correo   = mysqli_real_escape_string($conexion, $_POST['correo']);
$password = $_POST['password'];

$consulta = "SELECT * FROM usuarios WHERE correo = '$correo'";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);

if ($usuario && password_verify($password, $usuario['password'])) {
    $_SESSION['usuario'] = $usuario['correo'];
    $_SESSION['nombre_usuario'] = $usuario['nombre'];
    session_write_close();
    
    header("Location: principal.php");
    exit();
} else {
    echo '
        <script>
            alert("Correo o contraseña incorrectos");
            window.location = "index.php";
        </script>
    ';
}

mysqli_close($conexion);
?>