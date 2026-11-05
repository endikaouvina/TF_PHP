<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

?>

<!-- MENSAJE INFORMATIVO DE CIERRE DE SESIÓN -->
<div class="container">
    <div class="d-flex d-column justify-content-center">
        <div class="alert theme-info mb-5" role="alert">
            <p>Cerrando la sesión...</p>
        </div>
    </div>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';

?>
