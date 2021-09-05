<?php
    

    if(!isset($_SESSION)){
        session_start();
    }

    $auth = $_SESSION['login'] ?? false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página realizada para aprender PHP. Incluye tecnologías como SASS, javascript, html, sql">
    <meta name="keywords" content="Bienes, Raíces, PHP, SQL, JavaScript, SASS, HTML">
    <meta name="author" content="Franco Mendoza">
    
    <title>Bienes Raíces</title>
    <link rel="stylesheet" href="/build/css/app.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>

<body>

    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img src="/build/img/dark-mode.svg" class="dark-mode-boton" alt="Boton dark mode">
                    <nav class="navegacion">
                        <a href="/nosotros.php">Nosotros</a>
                        <a href="/anuncios.php">Anuncios</a>
                        <a href="/blog.php">Blog</a>
                        <a href="/contacto.php">Contacto</a>
                        <?php if($auth): ?>
                            <a href="cerrar-sesion.php">Cerrar sesión</a>
                        <?php else: ?>
                            <a href="login.php">Iniciar sesión</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div> <!-- Barra -->
            <?php echo $inicio ? '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>' : ''; ?>
        </div>
    </header>