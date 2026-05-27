<?php
include 'conexion.php';
session_start();

// Control de seguridad
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}

// Capturamos los datos del formulario de contacto
$nombre    = $_POST['nombre_completo'];
$dni       = $_POST['dni'];
$telefono  = $_POST['telefono'];
$correo    = $_POST['correo'];
$tipo      = $_POST['tipo_incidencia'];
$desc      = mysqli_real_escape_string($conexion, $_POST['descripcion']);

// Si escogió "Otro", capturamos el texto personalizado escrito por el usuario
if ($tipo === "Otro" && !empty($_POST['otro_motivo'])) {
    $tipo = "Otro: " . mysqli_real_escape_string($conexion, $_POST['otro_motivo']);
}

// --- LOGICA DE ALMACENAMIENTO DE ARCHIVOS (IMÁGENES/VIDEOS) ---
$nombreArchivoDb = ""; // Queda en blanco en la base de datos si el usuario no adjunta nada

if (isset($_FILES['evidencia']) && $_FILES['evidencia']['error'] == 0) {
    $nombreOriginal = $_FILES['evidencia']['name'];
    $rutaTemporal   = $_FILES['evidencia']['tmp_name'];
    
    // Agregamos una marca de tiempo única al nombre para evitar que archivos con nombres idénticos se sobreescriban
    $nuevoNombre    = time() . "_" . $nombreOriginal;
    $carpetaDestino = "uploads/" . $nuevoNombre;
    
    // Movemos el archivo temporal a la carpeta física de nuestro servidor local
    if (move_uploaded_file($rutaTemporal, $carpetaDestino)) {
        $nombreArchivoDb = $nuevoNombre; // Guardamos este nuevo nombre para enviarlo a MySQL
    }
}

// Inserción limpia a la base de datos de phpMyAdmin
$sql = "INSERT INTO reclamos (nombre_completo, dni, telefono, correo_electronico, tipo_incidencia, descripcion, evidencia) 
        VALUES ('$nombre', '$dni', '$telefono', '$correo', '$tipo', '$desc', '$nombreArchivoDb')";

if (mysqli_query($conexion, $sql)) {
    echo "<script>
            alert('¡Reclamo enviado correctamente con su evidencia! Gracias por tu feedback.');
            window.location.href = 'reclamos.php';
          </script>";
} else {
    echo "Error interno de base de datos al guardar: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>