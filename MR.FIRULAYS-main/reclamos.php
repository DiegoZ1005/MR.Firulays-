<?php
session_start();
// Candado de seguridad
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit();
}
$nombreUsuario = $_SESSION['nombre_usuario'];
$correoUsuario = $_SESSION['usuario'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MR. Firulays - Reclamos y Quejas</title>
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
                <li class="tab-item"><a href="#"><i class="fas fa-dog"></i> MIS MASCOTAS</a></li>
                <li class="tab-item"><a href="#"><i class="fas fa-credit-card"></i> PAGOS</a></li>
                <li class="tab-item active"><a href="reclamos.php"><i class="fas fa-comment-dots"></i> RECLAMOS/QUEJA</a></li>
            </ul>
            <div class="user-profile-menu">
                <span><?php echo $nombreUsuario; ?></span>
                <button onclick="window.location.href='logout.php'"><i class="fas fa-sign-out-alt"></i></button>
            </div>
        </nav>
    </header>

    <main class="panel-content-wrapper">
        <div class="welcome-banner" style="margin-bottom: 20px; background: white; padding: 20px; border-radius: 15px;">
            <h2 style="color: #004aad;">Bienvenido al panel de reclamos y quejas</h2>
            <p>Tu opinión nos ayuda a mejorar el servicio de nuestros especialistas.</p>
        </div>

        <!-- El enctype="multipart/form-data" es OBLIGATORIO para enviar archivos -->
        <form action="procesar_reclamo.php" method="POST" enctype="multipart/form-data">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                
                <!-- IZQUIERDA: DATOS DE CONTACTO -->
                <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <h3 style="color: #004aad; margin-bottom: 15px;"><i class="fas fa-user-edit"></i> Datos de contacto</h3>
                    
                    <label style="display: block; font-weight: 600; margin-bottom: 5px;">Nombre completo:</label>
                    <input type="text" name="nombre_completo" value="<?php echo $nombreUsuario; ?>" readonly style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f9f9f9;">

                    <div style="display: flex; gap: 10px;">
                        <div style="flex: 1;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px;">DNI:</label>
                            <input type="text" name="dni" required style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        </div>
                        <div style="flex: 1;">
                            <label style="display: block; font-weight: 600; margin-bottom: 5px;">Teléfono:</label>
                            <input type="text" name="telefono" required placeholder="999 999 999" style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd;">
                        </div>
                    </div>

                    <label style="display: block; font-weight: 600; margin-bottom: 5px;">Correo electrónico:</label>
                    <input type="email" name="correo" value="<?php echo $correoUsuario; ?>" readonly style="width:100%; margin-bottom:15px; padding:10px; border-radius:8px; border:1px solid #ddd; background:#f9f9f9;">

                    <label style="display: block; font-weight: 600; margin-bottom: 5px;">Tipo de incidencia:</label>
                    <select name="tipo_incidencia" id="tipo" onchange="checkOtro()" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd; cursor: pointer;">
                        <option value="Atención en Recepción (Naomi/Luis)">Atención de Personal (Recepción/Operador)</option>
                        <option value="Veterinaria General (Dra. Carmen Soto)">Servicio Médico (Dra. Carmen Soto)</option>
                        <option value="Cirugía (Dr. Alejandro Perez)">Cirugía Veterinaria (Dr. Alejandro)</option>
                        <option value="Grooming (Sofia Gomez)">Grooming - Baño/Corte (Sofia Gomez)</option>
                        <option value="Administración (Mariana Ruiz)">Gestión Administrativa (Mariana Ruiz)</option>
                        <option value="Limpieza/Instalaciones">Limpieza e Instalaciones</option>
                        <option value="Otro">U otro (Especificar motivo)</option>
                    </select>

                    <div id="div_otro" style="display:none; margin-top:15px;">
                        <label style="display: block; font-weight: 600; color: #004aad; margin-bottom: 5px;">Especifique el motivo:</label>
                        <input type="text" name="otro_motivo" id="input_otro" placeholder="¿Cuál es el problema?" style="width:100%; padding:10px; border-radius:8px; border:2px solid #004aad;">
                    </div>
                </div>

<div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); display:flex; flex-direction:column; align-items: center;">
    <h3 style="color: #004aad; margin-bottom: 15px; width: 100%; text-align: left;"><i class="fas fa-keyboard"></i> Detalle de la queja</h3>
    
    <label style="display: block; font-weight: 600; margin-bottom: 5px; width: 100%; text-align: left;">Descripción detallada:</label>
    <textarea name="descripcion" placeholder="Describe lo sucedido con respeto para ayudarte..." required style="width:100%; height:120px; padding:15px; border-radius:8px; border:1px solid #ddd; resize:none; margin-bottom:20px; font-family: inherit; box-sizing: border-box;"></textarea>
    
    <label style="border: 2px dashed #b5c7e3; border-radius: 12px; padding: 15px; text-align: center; background: #f8faff; width: 280px; cursor: pointer; display: block; box-sizing: border-box; transition: background 0.3s;" onmouseover="this.style.background='#f0f4ff'" onmouseout="this.style.background='#f8faff'">
        <i class="fas fa-cloud-upload-alt" style="font-size: 1.8rem; color: #004aad; margin-bottom: 8px;"></i>
        <p style="margin: 0; font-size: 0.95rem; font-weight: bold; color: #004aad;">Adjuntar evidencia</p>
        <p style="margin: 3px 0 8px 0; font-size: 0.75rem; color: #777;">Formatos: JPG, PNG, MP4</p>
        
        <span style="display: inline-block; background: #004aad; color: white; padding: 6px 12px; font-size: 0.8rem; font-weight: bold; border-radius: 6px;">
            <i class="fas fa-search" style="margin-right: 5px;"></i>Buscar archivo
        </span>
        
        <input type="file" name="evidencia" id="file-input" accept="image/jpeg, image/png, video/mp4" style="display: none;" onchange="updateFileName()">
    </label>
    
    <div id="file-name" style="margin-top: 8px; font-size: 0.8rem; color: #555; font-weight: 500; min-height: 16px;">Ningún archivo seleccionado</div>
    
    <button type="submit" style="margin-top: 25px; width: 180px; padding: 10px 15px; font-weight: bold; background: #004aad; color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 10px rgba(0, 74, 173, 0.2);">
        <i class="fas fa-paper-plane"></i> ENVIAR
    </button>
</div>


<script>
function updateFileName() {
    var input = document.getElementById('file-input');
    var output = document.getElementById('file-name');
    if (input.files && input.files.length > 0) {
        output.innerHTML = "<i class='fas fa-check-circle' style='color: #28a745;'></i> " + input.files[0].name;
    } else {
        output.innerText = "Ningún archivo seleccionado";
    }
}
</script>
</body>
</html>