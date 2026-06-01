<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // 1. Capturamos los datos
    $id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : 1; 
    $id_mascota = mysqli_real_escape_string($conexion, $_POST['id_mascota']);
    $servicio = mysqli_real_escape_string($conexion, $_POST['servicio']);
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora = mysqli_real_escape_string($conexion, $_POST['hora']);
    $id_veterinario = mysqli_real_escape_string($conexion, $_POST['id_veterinario']);

    // 2. Procesamos la imagen del comprobante de Yape
    $nombre_imagen = "";
    if (isset($_FILES['comprobante']) && $_FILES['comprobante']['error'] === UPLOAD_ERR_OK) {
        $carpeta_destino = 'uploads/';
        $extension = pathinfo($_FILES['comprobante']['name'], PATHINFO_EXTENSION);
        $nombre_imagen = 'voucher_' . time() . '_' . $id_usuario . '.' . $extension;
        $ruta_final = $carpeta_destino . $nombre_imagen;

        if (!move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta_final)) {
            die("Error al guardar la imagen en el servidor.");
        }
    } else {
        die("Debes adjuntar un comprobante de pago válido.");
    }

    // 3. INSERCIÓN 1: Guardamos la cita médica
    $sql_cita = "INSERT INTO citas (id_usuario, id_mascota, id_veterinario, servicio, fecha, hora, comprobante, estado) 
                 VALUES ('$id_usuario', '$id_mascota', '$id_veterinario', '$servicio', '$fecha', '$hora', '$nombre_imagen', 'Confirmado')";

    if (mysqli_query($conexion, $sql_cita)) {
        
        // 4. INSERCIÓN 2: Guardamos el historial en la tabla 'pagos'
        // Como la tabla 'pagos' pide el NOMBRE de la mascota y no el ID, lo consultamos rapidito:
        $res_mascota = mysqli_query($conexion, "SELECT nombre FROM mascotas WHERE id = '$id_mascota'");
        $row_mascota = mysqli_fetch_assoc($res_mascota);
        $nombre_mascota_str = $row_mascota['nombre'];
        
        $monto = "80.00"; // Tu monto fijo
        
        // Insertamos en pagos (boleta_url lo dejamos en NULL temporalmente o vacío)
        $sql_pago = "INSERT INTO pagos (id_usuario, fecha, nombre_mascota, servicio, monto, estado, boleta_url) 
                     VALUES ('$id_usuario', '$fecha', '$nombre_mascota_str', '$servicio', '$monto', 'Confirmado', NULL)";
        
        mysqli_query($conexion, $sql_pago);

        // 5. Redirigimos a la vista de pagos
        echo "<script>
                alert('¡Cita y pago registrados con éxito!');
                window.location.href = 'pagos.php';
              </script>";
        exit();
    } else {
        echo "Error en la BD al registrar la cita: " . mysqli_error($conexion);
    }

} else {
    header("Location: agendar_cita.php");
    exit();
}
?>