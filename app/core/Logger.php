<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'Logger'
class Logger {

    // Se define el método 'log_register()', que registrará los errores en archivos .log, categorizados por tipo de error y por fecha
    public function logRegister(string $message, string $log = 'app'): void {

        $line = '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL;
        $path = LOCAL_LOG_PATH . LOCAL_LOG_FILENAME . $log . '.log';

        // Se registra en 'logs/' si está disponible, sino, en el directorio correspondiente del servidor
        if (is_dir(LOCAL_LOG_PATH) && is_writable(LOCAL_LOG_PATH)) {
            error_log($line, 3, $path);
        } else {
            error_log('[' . $log . '] ' . $message);
        }

    }

}
