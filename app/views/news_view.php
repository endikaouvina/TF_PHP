<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se añade el head y el header
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/header.php';

/** @var News[] $news */

?>

<!-- LISTADO DE PRODUCTOS -->
<div class="container">
<?php if (empty($news)): ?>
    <div class="d-flex d-column justify-content-center">
        <div class="alert theme-secondary theme-contrast theme-border w-100 justify-content-center" role="alert">
            <p>No hay noticias disponibles.</p>
        </div>
    </div>
<?php else: ?>
    <h2 class="text-center">NOTICIAS</h2>
    <?php foreach ($news as $key => $new): ?>
        <div class="card card-row w-100 mt-9">
            <?php if ($key % 2 === 0): ?>
                <img src="<?= BASE_PATH . 'public/assets/img/news/' . htmlspecialchars($new->getImage(), ENT_QUOTES, SITE_CODIFICATION) ?>" class="card-img-start w-50">
            <?php endif; ?>
            <div class="card-body">
                <h3 class="card-title h4"><?= htmlspecialchars($new->getTitle(), ENT_QUOTES, SITE_CODIFICATION) ?></h3>
                <p class="card-text"><?= nl2br(htmlspecialchars($new->getText(), ENT_QUOTES, SITE_CODIFICATION)) ?></p>
                <p class="card-text"><small class="fg-2"><?= htmlspecialchars($new->getDateTime(), ENT_QUOTES, SITE_CODIFICATION) ?> - <?= htmlspecialchars($new->getUserName(), ENT_QUOTES, SITE_CODIFICATION) ?></small></p>
            </div>
            <?php if ($key % 2 !== 0): ?>
                <img src="<?= BASE_PATH . 'public/assets/img/news/' . htmlspecialchars($new->getImage(), ENT_QUOTES, SITE_CODIFICATION) ?>" class="card-img-end w-50">
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</div>

<?php

// Se añade el footer
require __DIR__ . '/partials/footer.php';

?>
