<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendar Cita</title>
    <link rel="stylesheet" href="css/panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="panel-body">
    
    <header class="panel-header">
        <nav class="navbar-panel">
            <div class="logo">
                <i class="fas fa-paw logo-icon"></i>
                <div class="logo-text">
                    <span>MR.Firulays</span><small class="sub-logo">Clínica Veterinaria</small>
                </div>
            </div>
            <ul class="panel-tabs">
                <li class="tab-item active"><a href="principal.php"><i class="fas fa-calendar-alt"></i> MIS CITAS</a></li>
                <li class="tab-item"><a href="mascotas.php"><i class="fas fa-dog"></i> MIS MASCOTAS</a></li>
                <li class="tab-item"><a href="pagos.php"><i class="fas fa-credit-card"></i> PAGOS</a></li>
                <li class="tab-item"><a href="reclamos.php"><i class="fas fa-comment-dots"></i> RECLAMOS/QUEJA</a></li>
            </ul>
            <div class="user-profile-menu">
                <span class="user-name-text"><?php echo htmlspecialchars($_SESSION['nombre_usuario']); ?></span>
            </div>
        </nav>
    </header>

    <div class="agendar-container">
        <div class="agendar-header">
            <h2>Agendar cita y gestión de mascotas</h2>
        </div>

        <form action="pagar.php" method="POST" class="agendar-grid">
            
            <div class="agendar-col">
                <div class="agendar-card">
                    <h3>1. Elige servicio</h3>
                    <label class="agendar-label">Servicio</label>
                    <select name="servicio" class="agendar-select" required>
                        <option value="" disabled selected>Selecciona un servicio</option>
                        <option value="Chequeo General">Chequeo General</option>
                        <option value="Vacunación">Vacunación</option>
                        <option value="Desparasitación">Desparasitación</option>
                        <option value="Cirugía">Cirugía</option>
                    </select>
                </div>

                <div class="agendar-card">
                    <h3>2. Selecciona fecha</h3>
                    <input type="date" name="fecha" class="agendar-date" required>
                </div>
            </div>

            <div class="agendar-col">
                <div class="agendar-card">
                    <h3>3. Selecciona horario disponible</h3>
                    
                    <div class="horarios-grid">
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="08:00">
                            <span>8:00 AM</span>
                        </label>
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="09:00" checked>
                            <span>9:00 AM</span>
                        </label>
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="10:00">
                            <span>10:00 AM</span>
                        </label>
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="11:00">
                            <span>11:00 AM</span>
                        </label>
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="13:00">
                            <span>1:00 PM</span>
                        </label>
                        <label class="hora-radio">
                            <input type="radio" name="hora" value="14:00">
                            <span>2:00 PM</span>
                        </label>
                    </div>

                </div>
            </div>

            <div class="agendar-col">
                <div class="agendar-card">
                    <h3>Mascotas registradas</h3>
                    
                    <?php
                    // Obtenemos el ID del usuario
                    $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 1; 

                    // Consultamos las mascotas
                    $sql_mascotas = "SELECT id, nombre, raza FROM mascotas WHERE id_usuario = '$id_usuario'";
                    $resultado_mascotas = mysqli_query($conexion, $sql_mascotas);

                    if ($resultado_mascotas && mysqli_num_rows($resultado_mascotas) > 0) {
                        $es_primero = true; 
                        
                        while ($mascota = mysqli_fetch_assoc($resultado_mascotas)) {
                            $checked = $es_primero ? 'checked' : '';
                            $foto_default = "https://cdn-icons-png.flaticon.com/512/1076/1076928.png";
                            
                            echo '<label class="mascota-radio-card">';
                            echo '    <input type="radio" name="id_mascota" value="' . $mascota['id'] . '" ' . $checked . ' required>';
                            echo '    <div class="mascota-card-content">';
                            echo '        <img src="' . $foto_default . '" alt="Foto Mascota">';
                            echo '        <div class="mascota-info">';
                            echo '            <h4>' . strtoupper(htmlspecialchars($mascota['nombre'])) . '</h4>';
                            echo '            <p>' . htmlspecialchars($mascota['raza']) . '</p>';
                            echo '        </div>';
                            echo '        <div class="radio-indicator"></div>';
                            echo '    </div>';
                            echo '</label>';
                            
                            $es_primero = false; 
                        }
                    } else {
                        echo '<p style="font-size: 13px; color: #666; text-align: center; padding: 20px 0;">No tienes mascotas registradas.</p>';
                    }
                    ?>
                </div>

              
            </div>
            
            <div class="agendar-acciones">
                <button type="submit" class="btn-confirmar">
                    <i class="far fa-calendar-check"></i> Confirmar reserva y pago
                </button>
                <a href="principal.php" class="btn-cancelar">Cancelar</a>
            </div>

        </form>
    </div>

</body>
</html>