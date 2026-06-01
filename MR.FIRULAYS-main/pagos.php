<?php
session_start();
include 'conexion.php'; // <--- Agrega esta línea para conectar a la BD

if (!isset($_SESSION['usuario'])) {
// ... el resto de tu código sigue igual
    echo "<script>
            alert('Acceso denegado. Por favor, inicia sesión para entrar al panel.');
            window.location.href = 'index.php';
          </script>";
    exit();
}

// Obtenemos el nombre del usuario para mostrarlo arriba
$nombreUsuario = isset($_SESSION['nombre_usuario']) ? $_SESSION['nombre_usuario'] : "Usuario";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR. Firulays - Pagos Realizados</title>
    <link rel="stylesheet" href="css/panel.css">
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
             <li class="tab-item"><a href="mascotas.php"><i class="fas fa-dog"></i> MIS MASCOTAS</a></li>
             <li class="tab-item active"><a href="pagos.php"><i class="fas fa-credit-card"></i> PAGOS</a></li>
             <li class="tab-item"><a href="reclamos.php"><i class="fas fa-comment-dots"></i> RECLAMOS/QUEJA</a></li>
            </ul>

            <div class="user-profile-menu">
                <div class="avatar-circle" id="userAvatar">
                    <i class="fas fa-user"></i>
                </div>
                <span class="user-name-text" id="userNameTop"><?php echo htmlspecialchars($nombreUsuario); ?></span>
                
                <button id="btnLogout" class="btn-small-logout" title="Cerrar Sesión" onclick="window.location.href='logout.php'">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="panel-content-wrapper">
        
        <section class="pagos-section">
            <h2 class="section-title">Pagos Realizados</h2>
            
            <div class="table-container">
                <table class="pagos-table">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Mascota</th>
                            <th>Servicio</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Comprobante</th>
                            <th></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                 <?php
                 // 1. Obtenemos el ID del usuario actual
                   // Nota: Usamos "1" por defecto para que puedas hacer pruebas si aún no pasas el id en el login
                  $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 1; 

                 // 2. Preparamos la consulta SQL para traer los pagos de este usuario
                 $sql = "SELECT id, fecha, nombre_mascota, servicio, monto, estado FROM pagos WHERE id_usuario = '$id_usuario' ORDER BY fecha DESC";
    
                 // 3. Ejecutamos la consulta
                  $resultado = mysqli_query($conexion, $sql);

                  // 4. Verificamos si la consulta fue exitosa y si hay filas devueltas
                 if ($resultado && mysqli_num_rows($resultado) > 0) {
        
                 // 5. El ciclo "while" dibujará un <tr> automáticamente por cada pago que encuentre en la BD
                 while ($fila = mysqli_fetch_assoc($resultado)) {
            
                  // Damos formato a la fecha (DD/MM/AAAA) y al monto (2 decimales)
                  $fecha_formateada = date("d/m/Y", strtotime($fila['fecha']));
                  $monto_formateado = number_format($fila['monto'], 2);

                   echo "<tr>";
                   echo "<td>" . $fecha_formateada . "</td>";
                   echo "<td>" . $fila['nombre_mascota'] . "</td>";
                   echo "<td>" . $fila['servicio'] . "</td>";
                   echo "<td>S/ " . $monto_formateado . "</td>";
                   echo "<td><span class='badge-estado'>" . $fila['estado'] . "</span></td>";
                   echo "<td><a href='vista_comprobante.php?id=" . $fila['id'] . "' class='btn-boleta' style='text-decoration: none; display: inline-block;'>Ver boleta</a></td>";
                   echo "<td><i class='fas fa-ellipsis-v config-icon'></i></td>";
                   echo "</tr>";
                 }
        
                  } else {
                     // 6. Si la tabla está vacía, mostramos este diseño limpio
                   echo "<tr><td colspan='7' style='padding: 30px; text-align: center; color: #666;'>Aún no tienes pagos registrados.</td></tr>";
                  }
                 ?>
                </tbody>


                </table>
            </div>
        </section>

    
    </main>
</body>
</html>