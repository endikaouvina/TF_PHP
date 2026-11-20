<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

// Se recogen las variables de otros archivos
/** @var array $registerFeedback */

?>

<!-- FORMULARIO DE REGISTRO -->
<div class="container">
    <h2 class="text-center">Registrarse</h2>
    <?php if (isset($registerFeedback['userRegistered'])): ?>
    <div class="d-flex d-column justify-content-center mt-5">
        <div class="alert theme-danger theme-border w-100 justify-content-center" role="alert">
            <p><?= $registerFeedback['userRegistered'] ?></p>
        </div>
    </div>
    <?php endif; ?>
    <form action="<?= BASE_PATH ?>registro.php" method="post">
        <div class="row g-2 gap-4">
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="name">Nombre *</label>
                    <input type="text" name="name" id="name" class="form-control <?= $registerFeedback['name']['inputClass'] ?? '' ?>" maxlength="<?= FORM_NAME_MAX_RANGE ?>" value="<?= isset($registerFeedback['name']['inputValue']) ? htmlspecialchars($registerFeedback['name']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['name']['feedbackClass']) && isset($registerFeedback['name']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['name']['feedbackClass'] ?>"><?= $registerFeedback['name']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="surname">Apellidos *</label>
                    <input type="text" name="surname" id="surname" class="form-control <?= $registerFeedback['surname']['inputClass'] ?? '' ?>" maxlength="<?= FORM_SURNAME_MAX_RANGE ?>" value="<?= isset($registerFeedback['surname']['inputValue']) ? htmlspecialchars($registerFeedback['surname']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['surname']['feedbackClass']) && isset($registerFeedback['surname']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['surname']['feedbackClass'] ?>"><?= $registerFeedback['surname']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-2 gap-4">
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="email">Email *</label>
                    <input type="email" name="email" id="email" class="form-control <?= $registerFeedback['email']['inputClass'] ?? '' ?>" maxlength="<?= FORM_EMAIL_MAX_RANGE ?>" value="<?= isset($registerFeedback['email']['inputValue']) ? htmlspecialchars($registerFeedback['email']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['email']['feedbackClass']) && isset($registerFeedback['email']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['email']['feedbackClass'] ?>"><?= $registerFeedback['email']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="tel">Teléfono *</label>
                    <input type="tel" name="tel" id="tel" class="form-control <?= $registerFeedback['tel']['inputClass'] ?? '' ?>" maxlength="<?= FORM_TEL_MAX_RANGE ?>" value="<?= isset($registerFeedback['tel']['inputValue']) ? htmlspecialchars($registerFeedback['tel']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['tel']['feedbackClass']) && isset($registerFeedback['tel']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['tel']['feedbackClass'] ?>"><?= $registerFeedback['tel']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-2 gap-4">
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="birth">Fecha de nacimiento *</label>
                    <input type="text" name="birth" id="birth" class="form-control <?= $registerFeedback['birth']['inputClass'] ?? '' ?>" data-bs-toggle="datepicker" data-bs-date-min="1900-01-01" data-bs-date-max="<?= date('Y-m-d') ?>" data-bs-locale="es-ES"
                    <?php if (isset($registerFeedback['birth']['validated']) && isset($registerFeedback['birth']['inputValue']) && $registerFeedback['birth']['validated']): ?>
                        data-bs-selected-dates="<?= htmlspecialchars(json_encode([$registerFeedback['birth']['inputValue']]), ENT_QUOTES, SITE_CODIFICATION) ?>"
                    <?php endif; ?>
                    autocomplete="off" placeholder="">
                </div>
                <?php if (isset($registerFeedback['birth']['feedbackClass']) && isset($registerFeedback['birth']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['birth']['feedbackClass'] ?>"><?= $registerFeedback['birth']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" id="address" class="form-control <?= $registerFeedback['address']['inputClass'] ?? '' ?>" maxlength="<?= FORM_ADDRESS_MAX_RANGE ?>" value="<?= isset($registerFeedback['address']['inputValue']) ? htmlspecialchars($registerFeedback['address']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['address']['feedbackClass']) && isset($registerFeedback['address']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['address']['feedbackClass'] ?>"><?= $registerFeedback['address']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-2 gap-4">
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="sex">Sexo *</label>
                    <select name="sex" id="sex" class="form-control <?= $registerFeedback['sex']['inputClass'] ?? '' ?>">
                        <option>Escoge uno</option>
                        <option value="Hombre" <?= (isset($registerFeedback['sex']['inputValue']) && $registerFeedback['sex']['inputValue'] === 'Hombre') ? 'selected' : '' ?>>Hombre</option>
                        <option value="Mujer" <?= (isset($registerFeedback['sex']['inputValue']) && $registerFeedback['sex']['inputValue'] === 'Mujer') ? 'selected' : '' ?>>Mujer</option>
                        <option value="No indicado" <?= (isset($registerFeedback['sex']['inputValue']) && $registerFeedback['sex']['inputValue'] === 'No indicado') ? 'selected' : '' ?>>No indicado</option>
                    </select>
                </div>
                <?php if (isset($registerFeedback['sex']['feedbackClass']) && isset($registerFeedback['sex']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['sex']['feedbackClass'] ?>"><?= $registerFeedback['sex']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="userName">Nombre de usuario *</label>
                    <input type="text" name="userName" id="userName" class="form-control <?= $registerFeedback['userName']['inputClass'] ?? '' ?>" maxlength="<?= FORM_USERNAME_MAX_RANGE ?>" value="<?= isset($registerFeedback['userName']['inputValue']) ? htmlspecialchars($registerFeedback['userName']['inputValue']) : '' ?>" placeholder="">
                </div>
                <?php if (isset($registerFeedback['userName']['feedbackClass']) && isset($registerFeedback['userName']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['userName']['feedbackClass'] ?>"><?= $registerFeedback['userName']['feedbackMessage'] ?></div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row g-2 gap-4">
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="pass1">Contraseña *</label>
                    <input type="password" name="pass1" id="pass1" class="form-control <?= $registerFeedback['pass1']['inputClass'] ?? '' ?>" maxlength="<?= FORM_PASS_MAX_RANGE ?>" placeholder="">
                    <div class="strength-bar" data-bs-strength></div>
                </div>
                <?php if (isset($registerFeedback['pass1']['feedbackClass']) && isset($registerFeedback['pass1']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['pass1']['feedbackClass'] ?>"><?= htmlspecialchars($registerFeedback['pass1']['feedbackMessage']) ?></div>
                <?php endif; ?>
            </div>
            <div class="md:col">
                <div class="form-floating mt-5">
                    <label for="pass2">Repite la contraseña *</label>
                    <input type="password" name="pass2" id="pass2" class="form-control <?= $registerFeedback['pass2']['inputClass'] ?? '' ?>" maxlength="<?= FORM_PASS_MAX_RANGE ?>" placeholder="">
                    <div class="strength-bar" data-bs-strength></div>
                </div>
                <?php if (isset($registerFeedback['pass2']['feedbackClass']) && isset($registerFeedback['pass2']['feedbackMessage'])): ?>
                    <div class="pt-1 ps-5 pe-5 <?= $registerFeedback['pass2']['feedbackClass'] ?>"><?= htmlspecialchars($registerFeedback['pass2']['feedbackMessage']) ?></div>
                <?php endif; ?>
            </div>
        </div>
        <p class="fg-secondary mt-5 mb-0">* Campo obligatorio</p>
        <button type="submit" class="btn-solid theme-secondary mt-5">Registrarse</button>
    </form>
    <div class="d-flex d-column justify-content-center mt-5">
        <div class="alert theme-secondary theme-border w-100 justify-content-center" role="alert">
            <p>¿Tienes ya una cuenta? Inicia sesión <a href="<?= BASE_PATH ?>login.php">aquí</a>.</p>
        </div>
    </div>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';
