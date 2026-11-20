<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

// Se recogen las variables de otros archivos
/** @var array $modifyFeedback */
/** @var User $user */

?>

<!-- PANTALLA 'PERFIL' -->
<div class="container">
    <h2 class="text-center">Perfil</h2>
    <div class="row mt-5">
        <div class="col-7 border-end">
            <p><strong>Nombre:</strong> <?= $user->getName() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=nombre">Modificar</a></p>
            <p><strong>Apellidos:</strong> <?= $user->getSurname() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=apellidos">Modificar</a></p>
            <p><strong>Email:</strong> <?= $user->getEmail() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=email">Modificar</a></p>
            <p><strong>Teléfono:</strong> <?= $user->getTel() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=telefono">Modificar</a></p>
            <p><strong>Fecha de nacimiento:</strong> <?= $user->getBirth() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=fecha_de_nacimiento">Modificar</a></p>
            <p><strong>Dirección:</strong> <?= $user->getAddress() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=direccion">Modificar</a></p>
            <p><strong>Sexo:</strong> <?= $user->getSex() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=sexo">Modificar</a></p>
            <p><strong>Nombre de usuario:</strong> <?= $user->getUserName() ?> · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=nombre_de_usuario">Modificar</a></p>
            <p><strong>Contraseña:</strong> ************ · <a href="<?= BASE_PATH ?>perfil.php?modificarDato=contrasena">Modificar</a></p>
        </div>
        <div class="col-5">
            <h3 class="text-center">Modificar dato</h3>
            <?php if (isset($_GET['modificarDato']) && in_array($_GET['modificarDato'], ['nombre', 'apellidos', 'email', 'telefono', 'fecha_de_nacimiento', 'direccion', 'sexo', 'nombre_de_usuario', 'contrasena'], true)): ?>
                <form action="<?= BASE_PATH ?>perfil.php?modificarDato=<?= $_GET['modificarDato'] ?>" method="post" class="mt-5">
                    <?php if ($_GET['modificarDato'] === 'nombre'): ?>
                        <div class="form-floating mt-5">
                            <label for="name">Nombre *</label>
                            <input type="text" name="name" id="name" class="form-control <?= $modifyFeedback['name']['inputClass'] ?? '' ?>" maxlength="<?= FORM_NAME_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['name']['inputValue'] ?? $user->getName(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'apellidos'): ?>
                        <div class="form-floating mt-5">
                            <label for="surname">Apellidos *</label>
                            <input type="text" name="surname" id="surname" class="form-control <?= $modifyFeedback['surname']['inputClass'] ?? '' ?>" maxlength="<?= FORM_SURNAME_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['surname']['inputValue'] ?? $user->getSurname(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'email'): ?>
                        <div class="form-floating mt-5">
                            <label for="email">Email *</label>
                            <input type="email" name="email" id="email" class="form-control <?= $modifyFeedback['email']['inputClass'] ?? '' ?>" maxlength="<?= FORM_EMAIL_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['email']['inputValue'] ?? $user->getEmail(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'telefono'): ?>
                        <div class="form-floating mt-5">
                            <label for="tel">Teléfono *</label>
                            <input type="tel" name="tel" id="tel" class="form-control <?= $modifyFeedback['tel']['inputClass'] ?? '' ?>" maxlength="<?= FORM_TEL_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['tel']['inputValue'] ?? $user->getTel(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'fecha_de_nacimiento'): ?>
                        <div class="form-floating mt-5">
                            <label for="birth">Fecha de nacimiento *</label>
                            <input type="text" name="birth" id="birth" class="form-control <?= $modifyFeedback['birth']['inputClass'] ?? '' ?>" data-bs-toggle="datepicker" data-bs-date-min="1900-01-01" data-bs-date-max="<?= date('Y-m-d') ?>" data-bs-locale="es-ES"
                            <?php if ((isset($modifyFeedback['birth']['validated']) && isset($modifyFeedback['birth']['inputValue']) && $modifyFeedback['birth']['validated']) || !isset($modifyFeedback)): ?>
                                data-bs-selected-dates="<?= htmlspecialchars(json_encode([$modifyFeedback['birth']['inputValue'] ?? $user->getBirth()]), ENT_QUOTES, SITE_CODIFICATION) ?>"
                            <?php else: ?>
                                value="<?= htmlspecialchars($modifyFeedback['birth']['inputValue'] ?? '', ENT_QUOTES, SITE_CODIFICATION) ?>"
                            <?php endif; ?>
                            autocomplete="off" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'direccion'): ?>
                        <div class="form-floating mt-5">
                            <label for="address">Dirección *</label>
                            <input type="text" name="address" id="address" class="form-control <?= $modifyFeedback['address']['inputClass'] ?? '' ?>" maxlength="<?= FORM_ADDRESS_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['address']['inputValue'] ?? $user->getAddress(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'sexo'): ?>
                        <div class="form-floating mt-5">
                            <label for="sex">Sexo *</label>
                            <select name="sex" id="sex" class="form-control <?= $modifyFeedback['sex']['inputClass'] ?? '' ?>">
                                <option>Escoge uno</option>
                                <option value="Hombre" <?= ($modifyFeedback['address']['inputValue'] ?? $user->getSex()) === 'Hombre' ? 'selected' : '' ?>>Hombre</option>
                                <option value="Mujer" <?= ($modifyFeedback['address']['inputValue'] ?? $user->getSex()) === 'Mujer' ? 'selected' : '' ?>>Mujer</option>
                                <option value="No indicado" <?= ($modifyFeedback['address']['inputValue'] ?? $user->getSex()) === 'No indicado' ? 'selected' : '' ?>>No indicado</option>
                            </select>
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'nombre_de_usuario'): ?>
                        <div class="form-floating mt-5">
                            <label for="userName">Nombre de usuario *</label>
                            <input type="text" name="userName" id="userName" class="form-control <?= $modifyFeedback['userName']['inputClass'] ?? '' ?>" maxlength="<?= FORM_USERNAME_MAX_RANGE ?>" value="<?= htmlspecialchars($modifyFeedback['userName']['inputValue'] ?? $user->getUserName(), ENT_QUOTES, SITE_CODIFICATION) ?>" placeholder="">
                        </div>
                    <?php elseif ($_GET['modificarDato'] === 'contrasena'): ?>
                        <div class="form-floating mt-5">
                            <label for="pass1">Nueva contraseña *</label>
                            <input type="password" name="pass1" id="pass1" class="form-control <?= $modifyFeedback['pass1']['inputClass'] ?? '' ?>" maxlength="<?= FORM_PASS_MAX_RANGE ?>" placeholder="">
                            <div class="strength-bar" data-bs-strength></div>
                        </div>
                        <div class="form-floating mt-5">
                            <label for="pass2">Repite la nueva contraseña *</label>
                            <input type="password" name="pass2" id="pass2" class="form-control <?= $modifyFeedback['pass2']['inputClass'] ?? '' ?>" maxlength="<?= FORM_PASS_MAX_RANGE ?>" placeholder="">
                            <div class="strength-bar" data-bs-strength></div>
                        </div>
                    <?php endif; ?>
                    <p class="fg-secondary mt-5 mb-0">* Campo obligatorio</p>
                    <?php if (isset($modifyFeedback)): ?>
                        <div class="pt-1 ps-5 pe-5 invalid-feedback">
                            <?php
                                if ($_GET['modificarDato'] === 'nombre') {
                                    echo htmlspecialchars($modifyFeedback['name']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'apellidos') {
                                    echo htmlspecialchars($modifyFeedback['surname']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'email') {
                                    echo htmlspecialchars($modifyFeedback['email']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'telefono') {
                                    echo htmlspecialchars($modifyFeedback['tel']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'fecha_de_nacimiento') {
                                    echo htmlspecialchars($modifyFeedback['birth']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'direccion') {
                                    echo htmlspecialchars($modifyFeedback['address']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'sexo') {
                                    echo htmlspecialchars($modifyFeedback['sex']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'nombre_de_usuario') {
                                    echo htmlspecialchars($modifyFeedback['userName']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                } elseif ($_GET['modificarDato'] === 'contrasena') {
                                    echo htmlspecialchars($modifyFeedback['pass1']['feedbackMessage'], ENT_QUOTES, SITE_CODIFICATION);
                                }

if (isset($modifyFeedback['userModified']) && !$modifyFeedback['userModified']) {
    echo ' Ha habido un error al modificar el usuario. Por favor, inténtalo de nuevo más tarde.';
}
?>
                        </div>
                    <?php endif; ?>
                    <a href="<?= BASE_PATH ?>perfil.php"><button type="button" class="btn-outline theme-secondary mt-5">Cancelar</button></a>
                    <button type="submit" class="btn-solid theme-secondary mt-5 ms-5">Modificar dato</button>
                </form>
            <?php else: ?>
                <?php if (isset($modifyFeedback['userModified'])): ?>
                    <?php if ($modifyFeedback['userModified']): ?>
                        <div class="alert theme-success theme border" role="alert">El usuario se ha modificado correctamente.</div>
                    <?php else: ?>
                        <div class="alert theme-danger theme border" role="alert">Ha habido un error al modificar el usuario. Por favor, inténtalo de nuevo más tarde.</div>
                    <?php endif; ?>
                <?php endif; ?>
                <p class="mt-5 text-center">Clica en <i>Modificar</i>, en un dato, para poder modificarlo aquí.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';
