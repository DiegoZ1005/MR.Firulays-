<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    echo "
    <script>
        alert('Acceso denegado. Por favor, inicia sesión para entrar al panel.');
        window.location.href = 'index.php';
    </script>
    ";
    exit();
}

$nombreUsuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : "Usuario";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR. Firulays - Mis Mascotas</title>
    <link rel="stylesheet" href="css/panel.css">
    <link rel="stylesheet" href="css/estilos_mascotas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="panel-body">

    <header class="panel-header">
        <nav class="navbar-panel">
            <div class="logo">
                <i class="fas fa-paw logo-icon"></i>
                <div class="logo-text">
                    <span>MR.Firulays</span>
                    <small class="sub-logo">Clínica Veterinaria</small>
                </div>
            </div>

           <ul class="panel-tabs">
    <li class="tab-item"><a href="principal.php"><i class="fas fa-calendar-alt"></i> MIS CITAS</a></li>
    <li class="tab-item active"><a href="mascotas.php"><i class="fas fa-dog"></i> MIS MASCOTAS</a></li>
    <li class="tab-item"><a href="pagos.php"><i class="fas fa-credit-card"></i> PAGOS</a></li>
    <li class="tab-item"><a href="reclamos.php"><i class="fas fa-comment-dots"></i> RECLAMOS/QUEJA</a></li>
</ul>

            <div class="user-profile-menu">
                <div class="avatar-circle" id="userAvatar">
                    <i class="fas fa-user"></i>
               
                 <?php
// Asegúrate de tener tu archivo de conexión incluido arriba
// include 'conexion.php';

$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 1; 

// Actualizamos el SELECT con los nombres exactos de tus columnas
$sql_mascotas = "SELECT nombre, edad, raza, caracteristicas, foto, ultima_atencion FROM mascotas WHERE id_usuario = '$id_usuario'";
$resultado_mascotas = mysqli_query($conexion, $sql_mascotas);

$colores_css = ['card-purple', 'card-pink', 'card-green', 'card-yellow', 'card-blue'];
$contador_color = 0;

if ($resultado_mascotas && mysqli_num_rows($resultado_mascotas) > 0) {
    while ($mascota = mysqli_fetch_assoc($resultado_mascotas)) {
        
        $color_actual = $colores_css[$contador_color % count($colores_css)];
        
        // Manejo de la foto real de tu base de datos
        // Asumiendo que guardas el nombre de la imagen en la carpeta 'img/'
        $foto_bd = $mascota['foto'];
        if (!empty($foto_bd) && $foto_bd != 'default_pet.png') {
            $ruta_foto = "img/" . htmlspecialchars($foto_bd); // Ajusta 'img/' si tu carpeta se llama distinto
        } else {
            $ruta_foto = "https://cdn-icons-png.flaticon.com/512/1076/1076928.png";
        }
        
        echo '<div class="pet-card ' . $color_actual . '">';
        echo '    <div class="pet-image">';
        echo '        <img src="' . $ruta_foto . '" alt="Foto Mascota" style="object-fit: cover; width: 100%; height: 100%; border-radius: 15px 15px 0 0;">';
        echo '    </div>';
        echo '    <div class="pet-info">';
        echo '        <h3>' . strtoupper(htmlspecialchars($mascota['nombre'])) . ' <i class="fas fa-paw"></i></h3>';
        
        $edad = !empty($mascota['edad']) ? htmlspecialchars($mascota['edad']) : 'No especificada';
        echo '        <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> ' . $edad . '</p>';
        
        echo '        <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> ' . htmlspecialchars($mascota['raza']) . '</p>';
        
        // Usamos 'caracteristicas' en lugar de 'descripcion'
        $caracteristicas = !empty($mascota['caracteristicas']) ? htmlspecialchars($mascota['caracteristicas']) : 'Sin descripción';
        echo '        <p><i class="fas fa-edit"></i> <strong>Descripción:</strong> ' . $caracteristicas . '</p>';
        
        // Usamos 'ultima_atencion' real
        $ultima_atencion = !empty($mascota['ultima_atencion']) ? htmlspecialchars($mascota['ultima_atencion']) : 'Sin consultas aún';
        echo '        <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> ' . $ultima_atencion . '</p>';
        
        echo '    </div>';
        echo '</div>';
        
        $contador_color++;
    }
} else {
    echo '<p style="grid-column: 1 / -1; text-align: center; color: #666; padding: 40px; font-size: 16px;">Aún no tienes mascotas registradas. ¡Anímate a agregar una!</p>';
}
?>
                    
                <div class="pet-info">
                    <h3>AQUILES <i class="fas fa-paw text-blue"></i></h3>
                    <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> 4 años</p>
                    <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> Gato atigrado</p>
                    <p><i class="far fa-edit"></i> <strong>Descripción:</strong> Independiente, elegante y tranquilo. Le encanta dormir al sol.</p>
                    <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> 12/04/2026</p>
                </div>
            </div>

            <div class="add-pet-card" onclick="window.location.href='agregar_mascota.php'">
                <div class="add-content">
                    <i class="fas fa-plus icon-plus"></i>
                    <p>Agregar nueva mascota <i class="fas fa-paw"></i></p>
                </div>
            </div>

        </div>

        <footer class="family-footer">
            <div class="footer-box">
                <i class="fas fa-heart heart-icon"></i>
                <div class="footer-text">
                    <h4>ELLOS SON PARTE DE NUESTRA FAMILIA</h4>
                    <ul>
                        <li>Gracias por confiar en nosotros para su cuidado y bienestar</li>
                    </ul>
                </div>
            </div>
        </footer>
    </main>

</body>
</html>