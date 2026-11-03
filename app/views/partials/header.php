<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

?>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-black bg-gradient fg-white">
        <div class="container">
            <h1><?= SITE_TITLE ?></h1>
            <nav>
                <a href="<?= BASE_PATH ?>" class="text-decoration-none fg-white">
                    <i class="fa-solid fa-house"></i> Inicio
                </a>
            </nav>
        </div>
    </header>
    <!-- CONTENEDOR PRINCIPAL: AQUÍ SE INSERTARÁ EL CONTENIDO DE CADA VISITA -->
    <main class="flex-grow-1">
