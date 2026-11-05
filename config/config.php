<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las credenciales de la base de datos y el entorno
require_once __DIR__ . '/.env.php';

// Se incorpora la clase que gestionará los permisos de acceso
require_once dirname(__DIR__) . '/app/core/Auth.php';

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

// Se definen las constantes de formularios
define('FORM_USERNAME_MIN_RANGE', 3);
define('FORM_USERNAME_MAX_RANGE', 50);
define('FORM_USERNAME_REGEXP', '/^\w{' . FORM_USERNAME_MIN_RANGE . ',' . FORM_USERNAME_MAX_RANGE . '}$/');
define('FORM_PASSWORD_MIN_RANGE', 4);
define('FORM_PASSWORD_MAX_RANGE', 50);

// Se protege la cookie de sesión
ini_set('session.use_strict_mode', '1');
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => PROJECT_ENVIRONMENT === 'development' ? false : true,
    'httponly' => true,
    'samesite' => 'Strict'
]);

// Se inicia la sesión, si no existe ninguna ya creada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
