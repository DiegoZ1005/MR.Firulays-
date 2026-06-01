<?php
session_start();
include 'conexion.php';

// Si alguien intenta entrar aquí sin pasar por agendar_cita, lo regresamos
if (!isset($_POST['id_mascota'])) {
    header("Location: agendar_cita.php");
    exit();
}

// 1. Recibimos los datos del paso anterior
$id_mascota = mysqli_real_escape_string($conexion, $_POST['id_mascota']);
// Si dejaste los servicios quemados en el HTML con el value="Cirugía", etc.
$nombre_servicio = mysqli_real_escape_string($conexion, $_POST['servicio']); 
$fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
$hora = mysqli_real_escape_string($conexion, $_POST['hora']);

// 2. Consultamos la BD para mostrar los datos reales de la mascota en el resumen
$query_mascota = mysqli_query($conexion, "SELECT nombre, foto FROM mascotas WHERE id = '$id_mascota'");
$data_mascota = mysqli_fetch_assoc($query_mascota);
$nombre_mascota = $data_mascota ? $data_mascota['nombre'] : 'Mascota';
$foto_mascota = (!empty($data_mascota['foto']) && $data_mascota['foto'] != 'default_pet.png') ? 'img/' . $data_mascota['foto'] : 'https://cdn-icons-png.flaticon.com/512/1076/1076928.png';

$precio_total = "80.00"; // Precio fijo para el ejemplo

// Determinamos el doctor internamente para mostrarlo en el resumen
$nombre_doctor = ($nombre_servicio === 'Cirugía') ? 'Dr. Alejandro Perez' : 'Dra. Carmen Soto';
$id_veterinario = ($nombre_servicio === 'Cirugía') ? 2 : 1;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmar Pago - MR. Firulays</title>
    <link rel="stylesheet" href="css/panel.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos específicos para la vista de pagar.php */
        .pagos-grid { display: grid; grid-template-columns: 280px 1fr 220px; gap: 20px; max-width: 1050px; margin: 30px auto; }
        .box-pago { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        
        /* Columna Izquierda: Resumen */
        .resumen-col { background: #f8fafc; }
        .resumen-col h4 { color: #1e3a8a; margin-bottom: 25px; font-size: 15px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; font-weight: 600;}
        .resumen-pet { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; }
        .resumen-pet img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; border: 1px solid #e2e8f0; }
        .resumen-item { margin-bottom: 18px; font-size: 13px; color: #475569; }
        .resumen-item i { width: 25px; color: #3b82f6; font-size: 16px; }
        .resumen-item strong { color: #1e3a8a; }
        .total-box { margin-top: 40px; text-align: center; border-top: 2px dashed #cbd5e1; padding-top: 20px;}
        .total-box p { font-size: 13px; color: #1e3a8a; font-weight: bold; margin: 0;}
        .total-box h2 { color: #1e3a8a; font-size: 28px; margin-top: 5px; }

        /* Columna Central: Yape */
        .centro-col { text-align: center; border: 2px solid #e2e8f0; }
        .centro-col h2 { color: #1e3a8a; font-size: 22px; margin-bottom: 10px; }
        .qr-yape { max-width: 200px; margin: 25px 0; border-radius: 10px; }
        
        /* Input de archivo personalizado */
        .file-upload-wrapper { margin: 25px 0; }
        .file-upload-input { display: none; }
        .file-upload-label { display: block; background: #f8fafc; border: 2px dashed #94a3b8; padding: 18px; border-radius: 8px; color: #1e3a8a; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .file-upload-label:hover { background: #e2e8f0; border-color: #1e3a8a; }
        
        /* Botones */
        .btn-finalizar { background: #004aad; color: white; border: none; padding: 14px 20px; border-radius: 8px; font-weight: bold; width: 100%; cursor: pointer; font-size: 15px; margin-bottom: 12px; transition: 0.3s;}
        .btn-finalizar:hover { background: #003082; }
        .btn-volver { display: block; border: 1px solid #cbd5e1; color: #64748b; padding: 12px; border-radius: 8px; text-decoration: none; width: 100%; box-sizing: border-box; font-weight: 500; transition: 0.3s;}
        .btn-volver:hover { background: #f1f5f9; color: #1e3a8a; }
        
        /* Columna Derecha: Info */
        .info-col { background: #eff6ff; text-align: left; }
        .info-col h4 { color: #1e3a8a; font-size: 15px; margin-bottom: 15px; }
        .info-col p { font-size: 13px; color: #475569; margin-bottom: 15px; line-height: 1.6; }
    </style>
</head>
<body class="panel-body">

    <!-- CABECERA (Copíala exactamente igual a la de agendar_cita.php si tienes un header con logo y menú) -->
    
    <main class="panel-content-wrapper">
        <!-- El enctype="multipart/form-data" es crucial para subir la imagen del voucher -->
        <form action="procesar_cita.php" method="POST" enctype="multipart/form-data" class="pagos-grid">
            
            <!-- CAMPOS OCULTOS para enviar todo a procesar_cita.php -->
            <input type="hidden" name="id_mascota" value="<?php echo htmlspecialchars($id_mascota); ?>">
            <input type="hidden" name="servicio" value="<?php echo htmlspecialchars($nombre_servicio); ?>">
            <input type="hidden" name="fecha" value="<?php echo htmlspecialchars($fecha); ?>">
            <input type="hidden" name="hora" value="<?php echo htmlspecialchars($hora); ?>">
            <input type="hidden" name="id_veterinario" value="<?php echo htmlspecialchars($id_veterinario); ?>">

            <!-- 1. Columna Resumen -->
            <div class="box-pago resumen-col">
                <h4><i class="fas fa-receipt"></i> Resumen de la cita</h4>
                
                <div class="resumen-pet">
                    <img src="<?php echo htmlspecialchars($foto_mascota); ?>" alt="Mascota">
                    <div>
                        <strong style="color: #1e3a8a; font-size: 15px; display: block;"><?php echo strtoupper(htmlspecialchars($nombre_mascota)); ?></strong>
                        <span style="font-size: 13px; color: #64748b;"><?php echo htmlspecialchars($nombre_servicio); ?></span>
                    </div>
                </div>

                <div class="resumen-item">
                    <i class="far fa-calendar-alt"></i> <strong>Fecha:</strong><br>
                    <span style="margin-left: 30px;"><?php echo htmlspecialchars($fecha); ?></span>
                </div>
                <div class="resumen-item">
                    <i class="far fa-clock"></i> <strong>Hora:</strong><br>
                    <span style="margin-left: 30px;"><?php echo htmlspecialchars($hora); ?></span>
                </div>
                <div class="resumen-item">
                    <i class="fas fa-user-md"></i> <strong>Veterinaria:</strong><br>
                    <span style="margin-left: 30px;"><?php echo htmlspecialchars($nombre_doctor); ?></span>
                </div>

                <div class="total-box">
                    <p>Total a pagar</p>
                    <h2>S/ <?php echo $precio_total; ?></h2>
                </div>
            </div>

            <!-- 2. Columna Central Yape -->
            <div class="box-pago centro-col">
                <h2>Confirmación de pago con Yape</h2>
                <p style="font-size: 14px; color: #64748b;">Para confirmar tu cita, escanea y yapea</p>
                
          <img src="img/qr-yape.jpeg" alt="QR Yape" style="max-width: 180px; width: 100%; height: auto; margin: 20px auto; display: block; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">     
                
                <div class="file-upload-wrapper">
                    <label for="comprobante" class="file-upload-label">
                        <i class="fas fa-cloud-upload-alt"></i> Adjunta captura de pago
                    </label>
                    <input type="file" id="comprobante" name="comprobante" class="file-upload-input" accept="image/png, image/jpeg, image/jpg" required>
                    <p style="font-size: 12px; margin-top: 8px; color: #94a3b8;">* Solo formatos JPG o PNG</p>
                </div>

                <p style="font-size: 16px; font-weight: bold; color: #1e3a8a; margin-bottom: 25px;">Total a pagar: S/ <?php echo $precio_total; ?></p>
                
                <button type="submit" class="btn-finalizar"><i class="fas fa-check-circle"></i> Confirmar y finalizar cita</button>
                <a href="agendar_cita.php" class="btn-volver">Volver</a>
            </div>

            <!-- 3. Columna Info Importante -->
            <div class="box-pago info-col">
                <h4>Importante</h4>
                <p>Tu cita será confirmada una vez validemos el pago.</p>
                <p>Te enviaremos la confirmación por WhatsApp.</p>
                <i class="fas fa-paw" style="color: #cbd5e1; font-size: 40px; display: block; text-align: right; margin-top: 40px;"></i>
            </div>

        </form>
    </main>

</body>
</html>