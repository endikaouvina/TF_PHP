<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

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

// En cualquier entorno, se guardan los errores en la directiva 'log_errors' de PHP
ini_set('log_errors', '1');
