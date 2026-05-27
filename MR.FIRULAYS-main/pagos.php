<?php
session_start();

// Protección: Si alguien intenta entrar sin iniciar sesión, lo devuelve al index
if (!isset($_SESSION['usuario'])) {
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
                        <tr>
                            <td>15/05/2026</td>
                            <td>Luna</td>
                            <td>Chequeo General</td>
                            <td>S/ 80.00</td>
                            <td><span class="badge-estado">Confirmado</span></td>
                            <td><button class="btn-boleta">Ver boleta</button></td>
                            <td><i class="fas fa-ellipsis-v config-icon"></i></td>
                        </tr>
                        <tr>
                            <td>10/05/2026</td>
                            <td>Ana</td>
                            <td>Vacuna Triple Felina</td>
                            <td>S/ 65.00</td>
                            <td><span class="badge-estado">Confirmado</span></td>
                            <td><button class="btn-boleta">Ver boleta</button></td>
                            <td><i class="fas fa-ellipsis-v config-icon"></i></td>
                        </tr>
                        <tr>
                            <td>05/05/2026</td>
                            <td>Wanda</td>
                            <td>Cesárea</td>
                            <td>S/ 250.00</td>
                            <td><span class="badge-estado">Confirmado</span></td>
                            <td><button class="btn-boleta">Ver boleta</button></td>
                            <td><i class="fas fa-ellipsis-v config-icon"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

    
    </main>
</body>
</html>