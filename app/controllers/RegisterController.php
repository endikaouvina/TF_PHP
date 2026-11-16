<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las clases necesarias
require_once dirname(__DIR__) . '/core/FormValidator.php';
require_once dirname(__DIR__) . '/models/UserDAO.php';
require_once dirname(__DIR__) . '/models/User.php';

// Se define la clase 'RegisterController'
class RegisterController {

    // Se define el método 'showRegister()', que mostrará el formulario de registro
    public function showRegister(): void {

        // Se recuperan los posibles mensajes guardados en la sesión y se eliminan de la misma
        $registerFeedback = $_SESSION['registerFeedback'] ?? null;
        unset($_SESSION['registerFeedback']);

        // Se entregan los datos a la vista
        $pageTitle = 'Registro | ';
        $registerActive = 'active';

        require dirname(__DIR__) . '/views/register_view.php';

    }

    // Se define el método 'register()', que comprobará los datos del formulario de registro, y si tienen el formato correcto, se registrará al usuario
    public function register(): void {

        // Se declara la variable '$registerFeedback', que se recogerá textos y clases para enviar a la vista a través de la variable de sesión
        $registerFeedback = [];

        // Se recogen los datos del formulario
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $email = $_POST['email'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $birth = $_POST['birth'] ?? '';
        $address = $_POST['address'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $userName = $_POST['userName'] ?? '';
        $pass1 = $_POST['pass1'] ?? '';
        $pass2 = $_POST['pass2'] ?? '';

        // Se valida cada dato del formulario
        $nameValidated = FormValidator::validateValue('name', $name, FORM_NAME_MIN_RANGE, FORM_NAME_MAX_RANGE, FORM_NAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras y espacios.');

        $surnameValidated = FormValidator::validateValue('surname', $surname, FORM_SURNAME_MIN_RANGE, FORM_SURNAME_MAX_RANGE, FORM_SURNAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras y espacios.');

        $emailValidated = FormValidator::validateValue('email', $email, FORM_EMAIL_MIN_RANGE, FORM_EMAIL_MAX_RANGE, '', 'El campo tiene un formato incorrecto. Se admite un formato de email válido.');

        $telValidated = FormValidator::validateValue('tel', $tel, FORM_TEL_MIN_RANGE, FORM_TEL_MAX_RANGE, FORM_TEL_REGEXP, "El campo tiene un formato incorrecto. Se admite un número de teléfono válido nacional (España) o internacional. Puede ir precedido por '+' o '00', y el prefijo del país.");

        $birthValidated = FormValidator::validateValue('birth', $birth, 0, 0, '', "El campo tiene un formato incorrecto. Se admite una fecha válida, en formato dd/mm/aaaa, separada por barra (/), por guion (-) o por punto (.).");

        $addressValidated = FormValidator::validateValue('address', $address, FORM_ADDRESS_MIN_RANGE, FORM_ADDRESS_MAX_RANGE, FORM_ADDRESS_REGEXP, "El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los símbolos ' ’ º ª ° . , / # ( ) -. Debe empezar por una letra o cifra.");

        $sexValidated = FormValidator::validateValue('sex', $sex, 0, 0, '', "El campo tiene un formato incorrecto. Se admiten los valores 'Hombre', 'Mujer' y 'No indicado'.");

        $userNameValidated = FormValidator::validateValue('userName', $userName, FORM_USERNAME_MIN_RANGE, FORM_USERNAME_MAX_RANGE, FORM_USERNAME_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras minúsculas del alfabeto inglés, cifras y el símbolo _. Debe empezar por una letra y terminar por una letra o cifra. No puede haber dos símbolos _ seguidos.');

        $pass1Validated = FormValidator::validateValue('pass1', $pass1, FORM_PASS_MIN_RANGE, FORM_PASS_MAX_RANGE, FORM_PASS_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los siguientes caracteres: ¡ ! ¿ ? ( ) { } [ ] / \ < > , ; . : - _ | \' " ´ ` ¨ ^ @ # $ % & = * + · ~ ¬ €. Debe haber, al menos, una letra mayúscula, una letra minúscula, una cifra y un símbolo.');

        $pass2Validated = FormValidator::validateValue('pass2', $pass2, FORM_PASS_MIN_RANGE, FORM_PASS_MAX_RANGE, FORM_PASS_REGEXP, 'El campo tiene un formato incorrecto. Se admiten letras, cifras, espacios y los siguientes caracteres: ¡ ! ¿ ? ( ) { } [ ] / \ < > , ; . : - _ | \' " ´ ` ¨ ^ @ # $ % & = * + · ~ ¬ €. Debe haber, al menos, una letra mayúscula, una letra minúscula, una cifra y un símbolo.');

        // Se añade el feedback de cada campo a la variable $registerFeedback
        $registerFeedback[$nameValidated['inputName']] = [
            'inputClass' => $nameValidated['inputClass'],
            'inputValue' => $nameValidated['inputValue'],
            'feedbackClass' => $nameValidated['feedbackClass'],
            'feedbackMessage' => $nameValidated['feedbackMessage']
        ];

        $registerFeedback[$surnameValidated['inputName']] = [
            'inputClass' => $surnameValidated['inputClass'],
            'inputValue' => $surnameValidated['inputValue'],
            'feedbackClass' => $surnameValidated['feedbackClass'],
            'feedbackMessage' => $surnameValidated['feedbackMessage']
        ];

        $registerFeedback[$emailValidated['inputName']] = [
            'inputClass' => $emailValidated['inputClass'],
            'inputValue' => $emailValidated['inputValue'],
            'feedbackClass' => $emailValidated['feedbackClass'],
            'feedbackMessage' => $emailValidated['feedbackMessage']
        ];

        $registerFeedback[$telValidated['inputName']] = [
            'inputClass' => $telValidated['inputClass'],
            'inputValue' => $telValidated['inputValue'],
            'feedbackClass' => $telValidated['feedbackClass'],
            'feedbackMessage' => $telValidated['feedbackMessage']
        ];

        $registerFeedback[$birthValidated['inputName']] = [
            'inputClass' => $birthValidated['inputClass'],
            'inputValue' => $birthValidated['inputValue'],
            'feedbackClass' => $birthValidated['feedbackClass'],
            'feedbackMessage' => $birthValidated['feedbackMessage']
        ];

        $registerFeedback[$addressValidated['inputName']] = [
            'inputClass' => $addressValidated['inputClass'],
            'inputValue' => $addressValidated['inputValue'],
            'feedbackClass' => $addressValidated['feedbackClass'],
            'feedbackMessage' => $addressValidated['feedbackMessage']
        ];

        $registerFeedback[$sexValidated['inputName']] = [
            'inputClass' => $sexValidated['inputClass'],
            'inputValue' => $sexValidated['inputValue'],
            'feedbackClass' => $sexValidated['feedbackClass'],
            'feedbackMessage' => $sexValidated['feedbackMessage']
        ];

        $registerFeedback[$userNameValidated['inputName']] = [
            'inputClass' => $userNameValidated['inputClass'],
            'inputValue' => $userNameValidated['inputValue'],
            'feedbackClass' => $userNameValidated['feedbackClass'],
            'feedbackMessage' => $userNameValidated['feedbackMessage']
        ];

        // Si las contraseñas tienen un formato válido, pero no coinciden, se cambian las clases correspondientes y el texto que se muestra en pantalla
        if ($pass1Validated['validated'] && $pass2Validated['validated'] && $pass1 !== $pass2) {
            $pass1Validated['inputClass'] = 'is-invalid';
            $pass1Validated['feedbackClass'] = 'invalid-feedback';
            $pass1Validated['feedbackMessage'] = 'El campo tiene un formato correcto, pero no coinciden las contraseñas.';
            $pass2Validated['inputClass'] = 'is-invalid';
            $pass2Validated['feedbackClass'] = 'invalid-feedback';
            $pass2Validated['feedbackMessage'] = 'El campo tiene un formato correcto, pero no coinciden las contraseñas.';
        }

        $registerFeedback[$pass1Validated['inputName']] = [
            'inputClass' => $pass1Validated['inputClass'],
            'inputValue' => $pass1Validated['inputValue'],
            'feedbackClass' => $pass1Validated['feedbackClass'],
            'feedbackMessage' => $pass1Validated['feedbackMessage']
        ];

        $registerFeedback[$pass2Validated['inputName']] = [
            'inputClass' => $pass2Validated['inputClass'],
            'inputValue' => $pass2Validated['inputValue'],
            'feedbackClass' => $pass2Validated['feedbackClass'],
            'feedbackMessage' => $pass2Validated['feedbackMessage']
        ];

        // Si todos los datos tienen un formato correcto (el campo 'Dirección' tiene asociado null cuando está vacío) y las contraseñas coinciden, se continúa con el proceso de validación
        if ($nameValidated['validated'] && $surnameValidated['validated'] && $emailValidated['validated'] && $telValidated['validated'] && $birthValidated['validated'] && ($addressValidated === null || $addressValidated['validated']) && $sexValidated['validated'] && $userNameValidated['validated'] && $pass1Validated['validated'] && $pass2Validated['validated'] && $pass1 === $pass2) {

            // Se comprueba que no haya ningún usuario con el email o el nombre de usuario introducidos
            $userDAO = new UserDAO();

            $userSearchedByEmail = $userDAO->searchByEmail($emailValidated['inputValue']);
            $userSearchedByUserName = $userDAO->searchByUserName($userNameValidated['inputValue']);

            if ($userSearchedByEmail !== null || $userSearchedByUserName !== null) {

                if ($userSearchedByEmail !== null) {
                    $registerFeedback['email']['inputClass'] = 'is-invalid';
                    $registerFeedback['email']['feedbackClass'] = 'invalid-feedback';
                    $registerFeedback['email']['feedbackMessage'] = 'El campo tiene un formato correcto, pero ya hay un usuario con el email introducido.';
                }

                if ($userSearchedByUserName !== null) {
                    $registerFeedback['userName']['inputClass'] = 'is-invalid';
                    $registerFeedback['userName']['feedbackClass'] = 'invalid-feedback';
                    $registerFeedback['userName']['feedbackMessage'] = 'El campo tiene un formato correcto, pero ya hay un usuario con el nombre de usuario introducido.';
                }

                // Se guarda el contenido de la variable '$registerFeedback' en la variable de sesión y se redirige de nuevo al formulario de registro
                $_SESSION['registerFeedback'] = $registerFeedback;
                header('Location: ' . BASE_PATH . 'registro.php');
                exit();

            }

            // Si todo es correcto, se genera el hash de la contraseña
            $passwordHash = password_hash($pass1, PASSWORD_DEFAULT);

            // Se cambia el formato de la fecha por el que acepta la BBDD
            $birthValidatedValue = $birthValidated['inputValue'];
            $date = explode('/', str_replace(['-', '.'], '/', $birthValidatedValue));
            $birthFormat = implode('-', [$date[2], $date[1], $date[0]]);

            // Se construye el objeto de la clase Usuario
            $user = new User(null, $nameValidated['inputValue'], $surnameValidated['inputValue'], $emailValidated['inputValue'], $telValidated['inputValue'], $birthFormat, $addressValidated['inputValue'] ?? null, $sexValidated['inputValue'], $userNameValidated['inputValue'], $passwordHash);

            // Si se registra el usuario correctamente, se guarda el mensaje de confirmación en la variable de sesión y se redirige al login; de lo contrario, se guarda el contenido de la variable '$registerFeedback' y se redirige de nuevo al formulario de registro
            if ($userDAO->registerUser($user)) {
                $_SESSION['registerFeedback']['userRegistered'] = 'El registro se ha completado correctamente. Ahora puedes acceder con tus credenciales.';
                header('Location: ' . BASE_PATH . 'login.php');
                exit();
            } else {
                $_SESSION['registerFeedback'] = $registerFeedback;
                $_SESSION['registerFeedback']['userRegistered'] = 'Ha habido un error al registrar al usuario. Por favor, inténtalo de nuevo más tarde.';
                header('Location: ' . BASE_PATH . 'registro.php');
                exit();
            }

        }

        // Si algún dato no es correcto, las contraseñas introducidas son diferentes o ya existe un usuario con el email o el nombre de usuario introducidos, se guarda el contenido de la variable '$registerFeedback' en la variable de sesión y se redirige de nuevo al formulario de registro
        $_SESSION['registerFeedback'] = $registerFeedback;
        header('Location: ' . BASE_PATH . 'registro.php');
        exit();

    }

}
