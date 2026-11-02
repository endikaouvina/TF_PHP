<?php

// Se tienen en cuenta todos los errores en cualquier entorno
error_reporting(E_ALL);

if (PROJECT_ENVIRONMENT === 'development') {
    // En desarrollo, los errores se muestran en pantalla
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    // En producción, los errores se ocultan
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}

// En cualquier entorno, se guardan los errores en 'logs/', un archivo por día
ini_set('log_errors', '1');
ini_set('error_log', LOG_PATH . 'php_' . LOG_FILENAME);
