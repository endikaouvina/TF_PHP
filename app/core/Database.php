<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incluyen las credenciales de la base de datos
require_once dirname(__DIR__, 2) . '/config/config.php';

// Se define la clase 'Database'
class Database {

    // Se define la propiedad estática '$connection', que almacenará la conexión
    private static ?PDO $connection = null;

    // Se define el método estático 'bd_connect()', que devuelve la conexión
    public static function dbConnect(string $path): ?PDO {

        // Si no existe una conexión, se crea
        if (self::$connection === null) {

            // Se construye el DSN
            $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';

            // Se restablecen las opciones de configuración de la conexión
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            // Se intenta realizar la conexión, gestionando los errores que puedan surgir en el proceso
            try {
                self::$connection = new PDO($dsn, DB_USER, DB_PASS, $options);
            } catch (PDOException $e) {
                Logger::registerLog('Ha fallado la conexión PDO a la base de datos desde ' . $path . '.', 'database');
                return null;
            }

        }

        // Se devuelve la conexión ya existente o la recién creada
        return self::$connection;

    }

}
