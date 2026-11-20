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

        // Se valida el formulario y se guarda el feedback en la variable '$registerFeedback'
        $registerFeedback = FormValidator::validateForm($name, $surname, $email, $tel, $birth, $address, $sex, $userName, $pass1, $pass2);

        // Si los datos recibidos se validan correctamente, se continúa el proceso de registro
        if ($registerFeedback['name']['validated'] && $registerFeedback['surname']['validated'] && $registerFeedback['email']['validated'] && $registerFeedback['tel']['validated'] && $registerFeedback['birth']['validated'] && ($registerFeedback['address'] === null || $registerFeedback['address']['validated']) && $registerFeedback['sex']['validated'] && $registerFeedback['userName']['validated'] && $registerFeedback['pass1']['validated'] && $registerFeedback['pass2']['validated']) {

            // Se genera el hash de la contraseña
            $passHash = password_hash($pass1, PASSWORD_DEFAULT);

            // Se construye el objeto de la clase User
            $user = new User(null, $registerFeedback['name']['inputValue'], $registerFeedback['surname']['inputValue'], $registerFeedback['email']['inputValue'], $registerFeedback['tel']['inputValue'], $registerFeedback['birth']['inputValue'], $registerFeedback['address']['inputValue'] ?? null, $registerFeedback['sex']['inputValue'], $registerFeedback['userName']['inputValue'], $passHash);

            // Si se registra el usuario correctamente, se guarda el mensaje de confirmación en la variable de sesión y se redirige al login; de lo contrario, se guarda el contenido de la variable '$registerFeedback' y se redirige de nuevo al formulario de registro
            $userDAO = new UserDAO();

            if ($userDAO->registerUser($user)) {
                $_SESSION['registerFeedback']['userRegistered'] = 'El registro se ha completado correctamente. Ya puedes acceder con tus credenciales.';
                header('Location: ' . BASE_PATH . 'login.php');
                exit();
            } else {
                $_SESSION['registerFeedback'] = $registerFeedback;
                $_SESSION['registerFeedback']['userRegistered'] = 'Ha habido un error al registrar al usuario. Por favor, inténtalo de nuevo más tarde.';
                header('Location: ' . BASE_PATH . 'registro.php');
                exit();
            }

        }

        // Si algún dato no es correcto, las contraseñas introducidas son diferentes o ya existe un usuario con el email o el nombre de usuario introducidos, se guarda el contenido de la variable '$registerFeedback' en la variable de sesión y se redirige de nuevo a la página de registro
        $_SESSION['registerFeedback'] = $registerFeedback;
        header('Location: ' . BASE_PATH . 'registro.php');
        exit();

    }

}
