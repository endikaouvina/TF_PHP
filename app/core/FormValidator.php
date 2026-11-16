<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'FormValidator', que se encargará de validar todos los inputs recibidos a través de los formularios
class FormValidator {

    // Se define el método 'validateValue()', que validará el dato pasado por parámetro; y retornará un array con el resultado de la validación, el dato validado o en formato string, clases CSS para la vista del formulario y un mensaje personalizado del error o validación
    public static function validateValue(string $inputName, mixed $value, int $minRange, int $maxRange, string $regExp, string $regExMessage): ?array {

        // Se comprueba que el dato sea un string
        if (!is_string($value)) {
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
        if ($value === '') {
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
            $value = trim(preg_replace('/[\s.\-()]/', '', $value));
        } elseif ($inputName !== 'pass1' && $inputName !== 'pass2') {
            $value = trim(preg_replace('/\s+/u', ' ', $value));
        }

        $length = mb_strlen($value, SITE_CODIFICATION);

        // Se comprueba que el dato tenga la longitud permitida, excepto en los campos 'Fecha de nacimiento' y 'Sexo', y, en el caso de contraseñas, también de bytes
        if (($inputName === 'pass1' || $inputName === 'pass2') && ($length < $minRange || $length > $maxRange || strlen($value) > 72)) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $value,
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => 'El campo tiene que tener entre ' . $minRange . ' y ' . $maxRange . ' caracteres, y un máximo de 72 bytes. Ten en cuenta que las letras con tildes, la ñ y la ç, en minúsculas o en mayúsculas, y los símbolos ¡ ¿ ´ "· ¬ cuentan como 2 bytes. Y el € y letras de algunos alfabetos, como el chino o el japonés, cuentan como 3 bytes.'
            ];
        } elseif ($inputName !== 'birth' && $inputName !== 'sex' && ($length < $minRange || $length > $maxRange)) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $value,
                'feedbackClass' => 'invalid-feedback',
                'feedbackMessage' => 'El campo tiene que tener entre ' . $minRange . ' y ' . $maxRange . ' caracteres.'
            ];
        }

        // Se valida el dato con el filtro FILTER_VALIDATE_EMAIL si es un email, con la función checkdate() si es una fecha o con su expresión regular si es otro campo
        $valueValidated = false;
        $sexValues = ['Hombre', 'Mujer', 'No indicado'];

        if ($inputName === 'email') {
            $valueValidated = filter_var($value, FILTER_VALIDATE_EMAIL);
        } elseif ($inputName === 'birth') {
            $date = explode('/', str_replace(['-', '.'], '/', $value));

            if (count($date) === 3 && checkdate((int) $date[1], (int) $date[0], (int) $date[2])) {
                $valueValidated = $value;
            }
        } elseif ($inputName === 'sex' && in_array($value, $sexValues, true)) {
            $valueValidated = $value;
        } else {
            $valueValidated = filter_var($value, FILTER_VALIDATE_REGEXP, ['options' => ['regexp' => $regExp]]);
        }

        if (!$valueValidated) {
            return [
                'validated' => false,
                'inputName' => $inputName,
                'inputClass' => 'is-invalid',
                'inputValue' => $value,
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

}
