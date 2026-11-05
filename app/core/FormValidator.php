<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'FormValidator', que se encargará de validar todos los inputs recibidos a través de los formularios
class FormValidator {

    // Se define el método 'validateUserName()', que validará el nombre de usuario
    public static function validateUserName(mixed $userName): bool|string {
        return filter_var($userName, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => FORM_USERNAME_REGEXP]]);
    }

}
