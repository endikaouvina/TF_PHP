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

// Se definen los ajustes del entorno
date_default_timezone_set('Europe/Madrid');
mb_internal_encoding(SITE_CODIFICATION);

// Se definen las constantes de formularios
define('FORM_NAME_MIN_RANGE', 2);
define('FORM_NAME_MAX_RANGE', 50);
define('FORM_NAME_REGEXP', '/\A(?=.{' . FORM_NAME_MIN_RANGE . ',' . FORM_NAME_MAX_RANGE . '}\z)\p{L}[\p{L}\p{M}]*(?:[ \'’-]\p{L}[\p{L}\p{M}]*)*\z/u');
define('FORM_SURNAME_MIN_RANGE', 2);
define('FORM_SURNAME_MAX_RANGE', 100);
define('FORM_SURNAME_REGEXP', '/\A(?=.{' . FORM_SURNAME_MIN_RANGE . ',' . FORM_SURNAME_MAX_RANGE . '}\z)\p{L}[\p{L}\p{M}]*(?:[ \'’-]\p{L}[\p{L}\p{M}]*)*\z/u');
define('FORM_EMAIL_MIN_RANGE', 5);
define('FORM_EMAIL_MAX_RANGE', 254);
define('FORM_TEL_MIN_RANGE', 3);
define('FORM_TEL_MAX_RANGE', 30);
define('FORM_TEL_REGEXP', '/\A(?:(?:\+34|0034)?[6-9][0-9]{8}|(?:\+|00)(?!34)[1-9][0-9]{6,14})\z/');
define('FORM_ADDRESS_MIN_RANGE', 5);
define('FORM_ADDRESS_MAX_RANGE', 150);
define('FORM_ADDRESS_REGEXP', '/\A(?=.{' . FORM_ADDRESS_MIN_RANGE . ',' . FORM_ADDRESS_MAX_RANGE . '}\z)[\p{L}0-9][\p{L}\p{M}0-9 \'’ºª°.,\/#()-]*\z/u');
define('FORM_USERNAME_MIN_RANGE', 3);
define('FORM_USERNAME_MAX_RANGE', 20);
define('FORM_USERNAME_REGEXP', '/\A(?=.{' . FORM_USERNAME_MIN_RANGE . ',' . FORM_USERNAME_MAX_RANGE . '}\z)[a-z](?:_?[a-z0-9])*\z/');
define('FORM_PASS_MIN_RANGE', 12);
define('FORM_PASS_MAX_RANGE', 40);
define('FORM_PASS_SYMBOLS', ' ' . preg_quote('¡!¿?(){}[]/\\<>,;.:-_|\'"´`¨^@#$%&=*+·~¬€', '/'));
define('FORM_PASS_REGEXP', '/\A(?=.*\p{Ll})(?=.*\p{Lu})(?=.*[0-9])(?=.*[' . FORM_PASS_SYMBOLS . '])' . '[\p{L}0-9' . FORM_PASS_SYMBOLS . ']{' . FORM_PASS_MIN_RANGE . ',' . FORM_PASS_MAX_RANGE . '}\z/u');

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
