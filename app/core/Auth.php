<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'Auth'
class Auth {

    // Se define el método 'isLogin()', que indicará si existe un usuario con la sesión iniciada
    public static function isLogin(): bool {
        return isset($_SESSION['user_id']);
    }

}
