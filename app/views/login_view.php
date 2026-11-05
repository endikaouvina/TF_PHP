<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

?>

<!-- FORMULARIO DE LOGIN -->
<div class="container">
    <h2 class="text-center">Iniciar sesión</h2>
    <form action="<?= BASE_PATH ?>login.php" method="post">
        <div class="form-floating mb-5">
            <label for="userName">Nombre de usuario</label>
            <input type="text" name="userName" id="userName" class="form-control" maxlength="<?= FORM_USERNAME_MAX_RANGE ?>" placeholder="">
        </div>
        <div class="form-floating mb-5">
            <label for="pass">Contraseña</label>
            <input type="password" name="pass" id="pass" class="form-control" maxlength="<?= FORM_PASSWORD_MAX_RANGE ?>" placeholder="">
        </div>
        <?php if (isset($error)): ?>
            <!-- MENSAJE DE ERROR TRAS UN INTENTO FALLIDO -->
            <div class="alert theme-danger mb-5" role="alert">
                <p><?= htmlspecialchars($error, ENT_QUOTES, SITE_CODIFICATION) ?></p>
            </div>
        <?php endif; ?>
        <button type="submit" class="btn-solid theme-secondary">Iniciar sesión</button>
    </form>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';

?>
