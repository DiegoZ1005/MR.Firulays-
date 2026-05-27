<?php
include 'conexion.php';
session_start();

$nombre   = $_POST['nombre'];
$dni      = $_POST['dni'];
$telefono = $_POST['telefono'];
$correo   = $_POST['correo'];
$password = $_POST['password'];

$password_fuerte = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO usuarios (nombre, dni, telefono, correo, password) 
        VALUES ('$nombre', '$dni', '$telefono', '$correo', '$password_fuerte')";

if (mysqli_query($conexion, $query)) {
    $_SESSION['usuario'] = $correo;
    $_SESSION['nombre_usuario'] = $nombre;
    
    header("Location: principal.php");
} else {
    echo "Error: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>