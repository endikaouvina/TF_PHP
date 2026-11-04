<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las credenciales de la base de datos y el entorno
require_once __DIR__ . '/.env.php';

// Se definen las constantes globales del sitio
define('SITE_TITLE', 'AL DÍA CON LAS NOTICIAS');
define('SITE_LANGUAGE', 'es');
define('SITE_CODIFICATION', 'UTF-8');
define('BASE_PATH', str_replace(realpath($_SERVER['DOCUMENT_ROOT']), '', dirname(__DIR__)) . '/');
define('LOCAL_LOG_PATH', dirname(__DIR__) . '/logs/');
define('LOCAL_LOG_FILENAME', date('Y-m-d') . '_');

// Se crea la ruta 'LOCAL_LOG_PATH' si no existe
if (!is_dir(LOCAL_LOG_PATH)) {
    mkdir(LOCAL_LOG_PATH, 0775, true);
}

// Se incorpora la clase 'Logger', encargada de registrar los errores de la aplicación
require_once dirname(__DIR__) . '/app/core/Logger.php';

// Se definen los ajustes del entorno
date_default_timezone_set('Europe/Madrid');
mb_internal_encoding(SITE_CODIFICATION);
