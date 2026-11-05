<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las clases necesarias
require_once dirname(__DIR__) . '/models/UserDAO.php';
require_once dirname(__DIR__) . '/core/FormValidator.php';

// Se define la clase 'AuthController'
class AuthController {

    // Se define el método 'showLogin()', que mostrará el formulario de inicio de sesión
    public function showLogin(): void {

        // Se recupera el posible mensaje de error guardado en la sesión y se elimina de la misma
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        // Se entregan los datos a la vista
        $pageTitle = 'Login | ';
        $loginActive = 'active';

        require dirname(__DIR__) . '/views/login_view.php';
    }

    // Se define el método 'login()', que comprobará las credenciales y, si son correctas, iniciará la sesión
    public function login(): void {

        // Se recogen los datos del formulario
        $userName = trim($_POST['userName'] ?? '');
        $pass = $_POST['pass'] ?? '';

        // Se valida el nombre de usuario
        if (FormValidator::validateUserName($userName)) {

            // Se obtiene el usuario a partir de su nombre de usuario
            $userDao = new UserDAO();
            $user = $userDao->searchByUserName($userName);

            // Se comprueba si el usuario existe y si la contraseña es correcta
            if ($user) {
                // Si las credenciales son correctas, se regenera el id de sesión, se guarda su identidad en la sesión y se redirige a la página de inicio
                if (password_verify($pass, $user->getPasswordHash())) {
                    session_regenerate_id(true);

                    $_SESSION['user_id'] = $user->getId();
                    $_SESSION['rol'] = $user->getRol();

                    header('Location: ' . BASE_PATH);
                    exit();
                } else {
                    Logger::registerLog('No se ha validado la contraseña en app/controllers/AuthController->tryLogin().', 'form_validator');
                }
            } else {
                Logger::registerLog('No se ha encontrado un usuario con el nombre de usuario introducido en app/controllers/AuthController->tryLogin().', 'form_validator');
            }

        } else {
            Logger::registerLog('No se ha validado el nombre de usuario en app/controllers/AuthController->tryLogin().', 'form_validator');
        }

        // Si las credenciales son incorrectas, se guarda un mensaje de error en la sesión y se redirige de nuevo al login
        $_SESSION['error'] = 'El nombre de usuario y/o la contraseña son incorrectos.';
        header('Location: ' . BASE_PATH . 'login.php');
        exit();

    }

    // Se define el método 'logout()', que cerrará la sesión del usuario y lo redirigirá a la página principal
    public function logout() {

        // Se vacía el contenido de la sesión
        $_SESSION = [];

        // Se elimina la cookie de sesión del navegador, si existe
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        // Se destruye la sesión por completo
        session_destroy();

        // Se entregan los datos a la vista
        $pageTitle = 'Cerrar sesión | ';
        $logoutActive = 'active';

        require dirname(__DIR__) . '/views/logout_view.php';

        // Se redirige a la página de inicio
        header('Location: ' . BASE_PATH);
        exit();

    }

}
