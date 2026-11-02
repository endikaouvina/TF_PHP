<?php

// Se incorporan las credenciales de la base de datos y el entorno
require_once __DIR__ . '/.env.php';

// Se definen las constantes globales del sitio
define('TITULO_SITIO', 'Tienda online');
define('IDIOMA_SITIO', 'es');
define('CODIFICATION', 'UTF-8');
define('BASE_PATH', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', dirname(__DIR__)) . '/');
define('LOG_PATH', BASE_PATH . 'logs/');
define('LOG_FILENAME', date('Y-m-d') . '.log');

// Se definen los ajustes del entorno
date_default_timezone_set('Europe/Madrid');
mb_internal_encoding(CODIFICATION);

// Se incorporan los ajustes de los errores
require_once __DIR__ . '/debug.php';
