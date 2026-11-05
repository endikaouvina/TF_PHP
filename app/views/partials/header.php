<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

?>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-black bg-gradient fg-white">
        <div class="container">
            <h1><?= SITE_TITLE ?></h1>
            <nav class="nav">
                <a href="<?= BASE_PATH ?>" class="nav-link <?= $indexActive ?? 'fg-white' ?>" aria-current="page">
                    <i class="fa-solid fa-house"></i> Inicio
                </a>
                <a href="<?= BASE_PATH ?>noticias.php" class="nav-link <?= $newsActive ?? 'fg-white' ?>">
                    <i class="fa-solid fa-newspaper"></i> Noticias
                </a>
                <?php if (!Auth::isLogin()): ?>
                    <a href="<?= BASE_PATH ?>login.php" class="nav-link <?= $loginActive ?? 'fg-white' ?>">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </a>
                <?php endif; ?>
                <?php if (Auth::isLogin()): ?>
                    <a href="<?= BASE_PATH ?>logout.php" class="nav-link <?= $logoutActive ?? 'fg-white' ?>">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Cerrar sesión
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- CONTENEDOR PRINCIPAL: AQUÍ SE INSERTARÁ EL CONTENIDO DE CADA VISITA -->
    <main class="flex-grow-1 py-9">
