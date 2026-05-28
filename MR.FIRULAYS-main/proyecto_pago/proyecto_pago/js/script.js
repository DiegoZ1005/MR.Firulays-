function verDetalles() {
    alert("Mostrando detalles de la cita veterinaria");
}

function reprogramar() {
    let nuevaFecha = prompt("Ingresa nueva fecha para la cita:");

    if(nuevaFecha != null && nuevaFecha != "") {
        alert("Cita reprogramada para: " + nuevaFecha);
    }
}

function volverInicio() {
    window.location.href = "index.php";
}
