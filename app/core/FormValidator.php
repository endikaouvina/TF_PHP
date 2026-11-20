<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'FormValidator', que se encargará de validar todos los inputs recibidos a través de los formularios
class FormValidator {

    // Se define el método 'validateValue()', que validará el dato pasado por parámetro; y retornará un array con el resultado de la validación, el dato validado o en formato string, clases CSS para la vista del formulario y un mensaje personalizado del error o validación
    private static function validateValue(string $inputName, mixed $inputValue, int $minRange, int $maxRange, string $regExp, string $regExMessage): ?array {

        // Se comprueba que el dato sea un string
        if (!is_string($inputValue)) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => '',
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => 'El campo tiene un formato incorrecto.'
            ];
        }

        // Se comprueba que el dato no esté vacío y se retorna null si el campo está vacío y es 'Dirección' (ya que no es obligatorio rellenarlo) o el array correspondiente si es otro campo
        if ($inputValue === '') {
            if ($inputName === 'address') {
                return null;
            } else {
                return [
                    'validated' => false,
                    'inputName' => $inputName,
                    'inputClass' => 'is-invalid',
                    'inputValue' => '',
                    'feedbackClass' => 'invalid-feedback',
                    'feedbackMessage' => 'El campo está vacío.'
                ];
            }
        }

        // Se sanea el dato y se calcula su longitud de caracteres
        if ($inputName === 'tel') {
            $inputValue = trim(preg_replace('/[\s.\-()]/', '', $inputValue));
        } elseif ($inputName !== 'pass1' && $inputName !== 'pass2') {
            $inputValue = trim(preg_replace('/\s+/u', ' ', $inputValue));
            if ($inputName === 'rol') {
                $inputValue = strtolower($inputValue);
            }
        }

        $length = mb_strlen($inputValue, SITE_CODIFICATION);

        // Se comprueba que el dato tenga la longitud permitida, excepto en los campos 'Fecha de nacimiento', 'Sexo' y 'Rol', y, en el caso de contraseñas, también de bytes
        if (($inputName === 'pass1' || $inputName === 'pass2') && ($length < $minRange || $length > $maxRange || strlen($inputValue) > 72)) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $inputValue,
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => 'El campo tiene que tener entre ' . $minRange . ' y ' . $maxRange . ' caracteres, y un máximo de 72 bytes. Ten en cuenta que las letras con tildes, la ñ y la ç, en minúsculas o en mayúsculas, y los símbolos ¡ ¿ ´ "· ¬ cuentan como 2 bytes. Y el € y letras de algunos alfabetos, como el chino o el japonés, cuentan como 3 bytes.'
            ];
        } elseif ($inputName !== 'birth' && $inputName !== 'sex' && $inputName !== 'rol' && ($length < $minRange || $length > $maxRange)) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $inputValue,
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => 'El campo tiene que tener entre ' . $minRange . ' y ' . $maxRange . ' caracteres.'
            ];
        }

        // Se valida el dato con el filtro FILTER_VALIDATE_EMAIL si es un email, con la función checkdate() si es una fecha, con un listado definido si es el sexo o el rol, o con su expresión regular si es otro campo
        $valueValidated = false;

        if ($inputName === 'email') {
            $valueValidated = filter_var($inputValue, FILTER_VALIDATE_EMAIL);
        } elseif ($inputName === 'birth') {
            $date = explode('/', str_replace(['-', '.'], '/', $inputValue));

            if (count($date) === 3 && checkdate((int) $date[1], (int) $date[0], (int) $date[2])) {
                if ((int) $date[0] < 10) {
                    $date[0] = '0' . $date[0];
                }
                if ((int) $date[1] < 10) {
                    $date[1] = '0' . $date[1];
                }
                $valueValidated = $date[2] . '-' . $date[1] . '-' . $date[0];
            }
        } elseif ($inputName === 'sex') {
            if (in_array($inputValue, ['Hombre', 'Mujer', 'No indicado'], true)) {
                $valueValidated = $inputValue;
            }
        } elseif ($inputName === 'rol') {
            if (in_array($inputValue, ['admin', 'user'], true)) {
                $valueValidated = $inputValue;
            }
        } else {
            $valueValidated = filter_var($inputValue, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $regExp]]);
        }

        if (!$valueValidated) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $inputValue,
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => $regExMessage
            ];
        }

        // Si ha pasado todas las comprobaciones, se retorna la validación del dato
        if ($inputName === 'pass1' || $inputName === 'pass2') {
            return [
                'validated' => true,
                'inputName' => $inputName,
                'inputClass' => 'is-valid',
                'inputValue' => '',
                'feedbackClass' => 'valid-feedback',
                'feedbackMessage' => 'El campo tiene un formato correcto. Por seguridad, si ha habido algún error, debes escribir de nuevo la contraseña.'
            ];
        } else {
            return [
                'validated' => true,
                'inputName' => $inputName,
                'inputClass' => 'is-valid',
                'inputValue' => $valueValidated,
                'feedbackClass' => 'valid-feedback',
                'feedbackMessage' => 'El campo tiene un formato correcto.'
            ];
        }

    }

    // Se define el método 'validateForm()', que validará cualquier formulario del sitio web
    public static function validateForm(string $formType, mixed $userName, mixed $pass1, mixed $pass2 = '', mixed $name = '', mixed $surname = '', mixed $email = '', mixed $tel = '', mixed $birth = '', mixed $address = '', mixed $sex = '', mixed $rol = ''): array {

        // Se declara la variable '$feedback', que recogerá textos y clases que devolverá a la función principal
        $feedback = [];

        // Se valida cada dato del formulario y se añade su feedback a la variable '$feedback'
        $feedback['name'] = self::validateValue('name', $name, FORM_NAME_MIN_RANGE, FORM_NAME_MAX_RANGE, FORM_NAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras y espacios.');

        $feedback['surname'] = self::validateValue('surname', $surname, FORM_SURNAME_MIN_RANGE, FORM_SURNAME_MAX_RANGE, FORM_SURNAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras y espacios.');

        $feedback['email'] = self::validateValue('email', $email, FORM_EMAIL_MIN_RANGE, FORM_EMAIL_MAX_RANGE, '', 'El campo tiene un formato incorrecto. Se admite un formato de email válido.');

        $feedback['tel'] = self::validateValue('tel', $tel, FORM_TEL_MIN_RANGE, FORM_TEL_MAX_RANGE, FORM_TEL_REGEXP, "El campo tiene un formato incorrecto. Se admite un número de teléfono válido nacional (España) o internacional. Puede ir precedido por '+' o '00', y el prefijo del país.");

        $feedback['birth'] = self::validateValue('birth', $birth, 0, 0, '', "El campo tiene un formato incorrecto. Se admite una fecha válida, en formato dd/mm/aaaa, separada por barra (/), por guion (-) o por punto (.).");

        $feedback['address'] = self::validateValue('address', $address, FORM_ADDRESS_MIN_RANGE, FORM_ADDRESS_MAX_RANGE, FORM_ADDRESS_REGEXP, "El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los símbolos ' ’ º ª ° . , / # ( ) -. Debe empezar por una letra o cifra.");

        $feedback['sex'] = self::validateValue('sex', $sex, 0, 0, '', "El campo tiene un formato incorrecto. Se admiten los valores 'Hombre', 'Mujer' y 'No indicado'.");

        $feedback['userName'] = self::validateValue('userName', $userName, FORM_USERNAME_MIN_RANGE, FORM_USERNAME_MAX_RANGE, FORM_USERNAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras minúsculas del alfabeto inglés, cifras y el símbolo _. Debe empezar por una letra y terminar por una letra o cifra. No puede haber dos símbolos _ seguidos.');

        $feedback['pass1'] = self::validateValue('pass1', $pass1, FORM_PASS_MIN_RANGE, FORM_PASS_MAX_RANGE, FORM_PASS_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los siguientes caracteres: ¡ ! ¿ ? ( ) { } [ ] / \ < > , ; . : - _ | \' " ´ ` ¨ ^ @ # $ % & = * + · ~ ¬ €. Debe haber, al menos, una letra mayúscula, una letra minúscula, una cifra y un símbolo.');

        $feedback['pass2'] = self::validateValue('pass2', $pass2, FORM_PASS_MIN_RANGE, FORM_PASS_MAX_RANGE, FORM_PASS_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los siguientes caracteres: ¡ ! ¿ ? ( ) { } [ ] / \ < > , ; . : - _ | \' " ´ ` ¨ ^ @ # $ % & = * + · ~ ¬ €. Debe haber, al menos, una letra mayúscula, una letra minúscula, una cifra y un símbolo.');

        $feedback['rol'] = self::validateValue('rol', $rol, 0, 0, '', "El campo tiene un formato incorrecto. Se admiten los valores 'Admin' y 'User'.");

        // Si no es el formulario de login y se han pasado contraseñas, tienen un formato válido y no coinciden, se cambian las clases correspondientes y el texto que se muestra en pantalla
        if ($formType !== 'login' && $feedback['pass1']['validated'] && $feedback['pass2']['validated'] && $pass1 !== $pass2) {
            $feedback['pass1']['validated'] = false;
            $feedback['pass1']['inputClass'] = 'is-invalid';
            $feedback['pass1']['feedbackClass'] = 'invalid-feedback';
            $feedback['pass1']['feedbackMessage'] = 'El campo tiene un formato correcto, pero no coinciden las contraseñas.';
            $feedback['pass2']['validated'] = false;
            $feedback['pass2']['inputClass'] = 'is-invalid';
            $feedback['pass2']['feedbackClass'] = 'invalid-feedback';
            $feedback['pass2']['feedbackMessage'] = 'El campo tiene un formato correcto, pero no coinciden las contraseñas.';
        }

        // Se guarda en la variable $feedback si existe o no algún usuario con el email o el nombre de usuario introducidos; éste último, si no es el formulario de login
        $userDao = new UserDAO();

        if ($userDao->searchByEmail($feedback['email']['inputValue'])) {
            $feedback['email']['validated'] = false;
            $feedback['email']['inputClass'] = 'is-invalid';
            $feedback['email']['feedbackClass'] = 'invalid-feedback';
            $feedback['email']['feedbackMessage'] = 'El campo tiene un formato correcto, pero ya hay un usuario con el email introducido.';
        }

        if ($formType !== 'login' && $userDao->searchByUserName($feedback['userName']['inputValue'])) {
            $feedback['userName']['validated'] = false;
            $feedback['userName']['inputClass'] = 'is-invalid';
            $feedback['userName']['feedbackClass'] = 'invalid-feedback';
            $feedback['userName']['feedbackMessage'] = 'El campo tiene un formato correcto, pero ya hay un usuario con el nombre de usuario introducido.';
        }

        return $feedback;
    }

}
