<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se recogen las variables de otros archivos
/** @var string $pageTitle */

?>
<!DOCTYPE html>
<html lang="<?= SITE_LANGUAGE ?>" data-bs-theme="light">
<head>
    <meta charset="<?= SITE_CODIFICATION ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($pageTitle ?? '') . SITE_TITLE ?></title>

    <!-- HOJA DE ESTILOS DE BOOTSTRAP -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/vendor/bootstrap_v6.0.0_alpha.1/css/bootstrap.min.css">

    <!-- HOJAS DE ESTILOS DE FONTAWESOME -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/vendor/fontawesome_v7.3.1/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/vendor/fontawesome_v7.3.1/css/regular.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/vendor/fontawesome_v7.3.1/css/brands.min.css">
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/vendor/fontawesome_v7.3.1/css/solid.min.css">

    <!-- HOJA DE ESTILOS PROPIA -->
    <link rel="stylesheet" href="<?= BASE_PATH ?>assets/css/styles.css">
</head>
