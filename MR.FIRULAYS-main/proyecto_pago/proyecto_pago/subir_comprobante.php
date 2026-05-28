<?php

if(isset($_FILES['comprobante'])) {

    $archivo = $_FILES['comprobante'];

    $nombre = $archivo['name'];
    $tmp = $archivo['tmp_name'];
    $size = $archivo['size'];

    $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

    $permitidos = ['jpg', 'jpeg', 'png'];

    if(!in_array($extension, $permitidos)) {
        die("Formato no permitido");
    }

    if($size > 5000000) {
        die("Archivo demasiado grande");
    }

    if(!is_dir('uploads')) {
        mkdir('uploads');
    }

    $nuevoNombre = time() . '_' . $nombre;

    move_uploaded_file($tmp, 'uploads/' . $nuevoNombre);

    header("Location: confirmar_pago.php");
    exit();
}
?>
