<?php
$mascota = "LUNA";
$fecha = "05/06/2026";
$hora = "10:00 AM";
$servicio = "Chequeo General";
$veterinaria = "Dra. Carmen Soto";
$estado = "Confirmada";
$total = 80;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Pago Veterinaria</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<div class="container">

    <div class="left-panel">

        <h2>Bienvenido al panel de citas</h2>
        <h3>Próximas citas</h3>

        <div class="card-cita">
            <img src="https://eq2imhfmrcc.exactdn.com/wp-content/uploads/2016/08/golden-retriever.jpg?strip=all" alt="Mascota">

            <div class="info">
                <p><strong><?php echo $fecha; ?></strong></p>
                <p><?php echo $hora; ?></p>
                <h4><?php echo $mascota; ?></h4>
                <p><?php echo $servicio; ?></p>
                <p>Veterinaria: <?php echo $veterinaria; ?></p>
                <p>Estado: <span class="confirmado"><?php echo $estado; ?></span></p>
            </div>

            <div class="botones-card">
                <button onclick="verDetalles()">Ver detalles</button>
                <button onclick="reprogramar()">Reprogramar</button>
            </div>
        </div>

    </div>

    <div class="right-panel">

        <h1>Confirmación de pago con Yape</h1>
        <p>Para confirmar tu cita, escanea y yapea</p>

        <div class="qr-container">

            <div class="qr-box">

                <h2 class="titulo-qr">
                    Escanea aquí el QR
                </h2>

                <img src="https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=YAPE" alt="Yape QR">

                <p>Yape</p>

            </div>

        </div>

        <div class="numero-yape">
            Número de yape: <strong>923878253</strong>
        </div>

        <form action="subir_comprobante.php" method="POST" enctype="multipart/form-data">

            <div class="upload-box">
                <label for="comprobante">Adjunta Captura de Pago</label>
                <input type="file" name="comprobante" id="comprobante" required>
                <small>Formatos permitidos: JPG, PNG (Máx. 5MB)</small>
            </div>

            <div class="total-box">
                Total a yapear: <strong>S/. <?php echo $total; ?></strong>
            </div>

            <div class="botones-principales">

                <button type="submit" class="confirmar-btn">
                    Confirmar y finalizar cita
                </button>

                <button type="button" class="volver-btn" onclick="volverInicio()">
                    Volver
                </button>

            </div>

        </form>

    </div>

</div>

<script src="js/script.js"></script>
</body>
</html>
