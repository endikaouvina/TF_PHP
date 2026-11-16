<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

// Se recogen las variables de otros archivos
/** @var string $error */
/** @var array $registerFeedback */

?>

<!-- FORMULARIO DE LOGIN -->
<div class="container">
    <h2 class="text-center">Iniciar sesión</h2>
    <?php if (isset($registerFeedback['userRegistered'])): ?>
    <div class="d-flex d-column justify-content-center mt-5">
        <div class="alert theme-success theme-border w-100 justify-content-center" role="alert">
            <p><?= $registerFeedback['userRegistered'] ?></p>
        </div>
    </div>
    <?php endif; ?>
    <form action="<?= BASE_PATH ?>login.php" method="post">
        <div class="form-floating mt-5">
            <label for="userName">Nombre de usuario *</label>
            <input type="text" name="userName" id="userName" class="form-control" maxlength="<?= FORM_USERNAME_MAX_RANGE ?>" placeholder="">
        </div>
        <div class="form-floating mt-5">
            <label for="pass">Contraseña *</label>
            <input type="password" name="pass" id="pass" class="form-control" maxlength="<?= FORM_PASS_MAX_RANGE ?>" placeholder="">
        </div>
        <?php if (isset($error)): ?>
            <!-- MENSAJE DE ERROR TRAS UN INTENTO FALLIDO -->
            <div class="alert theme-danger mt-5" role="alert">
                <p><?= htmlspecialchars($error, ENT_QUOTES, SITE_CODIFICATION) ?></p>
            </div>
        <?php endif; ?>
        <p class="fg-secondary mt-5 mb-0">* Campo obligatorio</p>
        <button type="submit" class="btn-solid theme-secondary mt-5">Iniciar sesión</button>
    </form>
    <div class="d-flex d-column justify-content-center mt-5">
        <div class="alert theme-secondary theme-border w-100 justify-content-center" role="alert">
            <p>¿No tienes una cuenta? Regístrate <a href="<?= BASE_PATH ?>registro.php">aquí</a>.</p>
        </div>
    </div>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';

?>
