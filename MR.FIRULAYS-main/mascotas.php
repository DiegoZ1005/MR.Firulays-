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
    <li class="tab-item"><a href="#"><i class="fas fa-credit-card"></i> PAGOS</a></li>
    <li class="tab-item"><a href="reclamos.php"><i class="fas fa-comment-dots"></i> RECLAMOS/QUEJA</a></li>
</ul>

            <div class="user-profile-menu">
                <div class="avatar-circle" id="userAvatar">
                    <i class="fas fa-user"></i>
                </div>
                <span class="user-name-text" id="userNameTop"><?php echo $nombreUsuario; ?></span>
                
                <button id="btnLogout" class="btn-small-logout" title="Cerrar Sesión" onclick="window.location.href='logout.php'">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </div>
        </nav>
    </header>

    <main class="panel-content-wrapper">
        <section class="welcome-container-pets">
            <h2 class="pets-main-title">Mis mascotas</h2>
            <p class="pets-sub-title">Aquí puedes ver a tus compañeros y toda su información</p>
        </section>

        <div class="pets-grid">
            
            <div class="pet-card card-purple">
                <div class="pet-image">
                    <img src="img/luna1.avif" alt="Luna">
                </div>
                <div class="pet-info">
                    <h3>LUNA <i class="fas fa-paw text-purple"></i></h3>
                    <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> 3 años</p>
                    <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> Golden Retriever</p>
                    <p><i class="far fa-edit"></i> <strong>Descripción:</strong> Cariñosa, juguetona y muy obediente. Le encanta correr y estar al aire libre.</p>
                    <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> 15/04/2026</p>
                </div>
            </div>

            <div class="pet-card card-pink">
                <div class="pet-image">
                    <img src="img/ana.jpg" alt="Ana">
                </div>
                <div class="pet-info">
                    <h3>ANA <i class="fas fa-paw text-pink"></i></h3>
                    <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> 2 años</p>
                    <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> Cocker Spaniel</p>
                    <p><i class="far fa-edit"></i> <strong>Descripción:</strong> Dulce, tranquila y muy sociable. Disfruta los paseos y los mimos.</p>
                    <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> 08/04/2026</p>
                </div>
            </div>

            <div class="pet-card card-green">
                <div class="pet-image">
                    <img src="img/donperro.jpg" alt="Don Perro">
                </div>
                <div class="pet-info">
                    <h3>DON PERRO <i class="fas fa-paw text-green"></i></h3>
                    <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> 1 año</p>
                    <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> Gato doméstico</p>
                    <p><i class="far fa-edit"></i> <strong>Descripción:</strong> Curioso, activo y travieso. Le gusta explorar y dormir en su manta.</p>
                    <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> 20/04/2026</p>
                </div>
            </div>

            <div class="pet-card card-yellow">
                <div class="pet-image">
                    <img src="img/wanda1.avif" alt="Wanda">
                </div>
                <div class="pet-info">
                    <h3>WANDA <i class="fas fa-paw text-yellow"></i></h3>
                    <p><i class="far fa-calendar-alt"></i> <strong>Edad:</strong> 5 años</p>
                    <p><i class="fas fa-ribbon"></i> <strong>Raza:</strong> Labrador Retriever</p>
                    <p><i class="far fa-edit"></i> <strong>Descripción:</strong> Protectora, noble y muy inteligente. Ama estar en familia.</p>
                    <p class="last-visit"><i class="far fa-clock"></i> <strong>Última atención:</strong> 01/04/2026</p>
                </div>
            </div>

            <div class="pet-card card-blue">
                <div class="pet-image">
                    <img src="img/aquiles.jpeg" alt="Aquiles">
                </div>
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