<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las clases necesarias
require_once dirname(__DIR__) . '/core/FormValidator.php';
require_once dirname(__DIR__) . '/models/UserDAO.php';
require_once dirname(__DIR__) . '/models/User.php';

// Se declara la clase 'ProfileController'
class ProfileController {

    // Se define el método 'showProfile()', que mostrará el perfil del usuario
    public function showProfile(): void {

        // Se recuperan los posibles mensajes guardados en la sesión y se eliminan de la misma
        $modifyFeedback = $_SESSION['modifyFeedback'] ?? null;
        unset($_SESSION['modifyFeedback']);

        // Se obtienen los datos del usuario que tiene la sesión iniciada
        $userDAO = new UserDAO();
        $user = $userDAO->searchById($_SESSION['user_id']);

        // Se entregan los datos a la vista
        $pageTitle = 'Perfil | ';
        $profileActive = 'active';

        require dirname(__DIR__) . '/views/profile_view.php';
    }

    // Se define el método 'modifyProfile()', que valida los datos recibidos por el formulario y modifica el usuario en la BBDD
    public function modifyProfile(): void {

        // Se recogen los datos del formulario
        $name = $_POST['name'] ?? '';
        $surname = $_POST['surname'] ?? '';
        $email = $_POST['email'] ?? '';
        $tel = $_POST['tel'] ?? '';
        $birth = $_POST['birth'] ?? '';
        $address = $_POST['address'] ?? '';
        $sex = $_POST['sex'] ?? '';
        $pass1 = $_POST['pass1'] ?? '';
        $pass2 = $_POST['pass2'] ?? '';
        $rol = $_POST['rol'] ?? '';

        // Se valida el formulario y se guarda el feedback en la variable '$modifyFeedback'
        $modifyFeedback = FormValidator::validateForm('profile', '', $pass1, $pass2, $name, $surname, $email, $tel, $birth, $address, $sex, $rol);

        // Se obtienen los datos del usuario con la sesión iniciada
        $userDAO = new UserDAO();
        $user = $userDAO->searchById($_SESSION['user_id']);

        // Si los datos recibidos se validan correctamente, se modifican en el usuario de la variable '$user' y se pasa a true la variable '$formValidated'
        $formValidated = false;

        if ($modifyFeedback['name']['validated']) {
            $user->setName($modifyFeedback['name']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['surname']['validated']) {
            $user->setSurname($modifyFeedback['surname']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['email']['validated']) {
            $user->setEmail($modifyFeedback['email']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['tel']['validated']) {
            $user->setTel($modifyFeedback['tel']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['birth']['validated']) {
            $user->setBirth($modifyFeedback['birth']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['address']['validated']) {
            $user->setAddress($modifyFeedback['address']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['sex']['validated']) {
            $user->setSex($modifyFeedback['sex']['inputValue']);
            $formValidated = true;
        } elseif ($modifyFeedback['pass1']['validated']) {
            $user->setPassHash(password_hash($modifyFeedback['pass1']['inputValue'], PASSWORD_DEFAULT));
            $formValidated = true;
        }

        // Se guarda el contenido de la variable '$modifyFeedback' en la variable de sesión
        $_SESSION['modifyFeedback'] = $modifyFeedback;

        // Si todos los datos son válidos, se modifica el usuario en la BBDD
        if ($formValidated) {
            $userModified = $userDAO->modifyUser($user);

            // Se guarda en la variable de sesión si el usuario ha sido modificado o no, y en caso afirmativo, se redirige de nuevo a la página de perfil (sin parámetros)
            if ($userModified) {
                $_SESSION['modifyFeedback']['userModified'] = true;
                header('Location: ' . BASE_PATH . 'perfil.php');
                exit();
            } else {
                $_SESSION['modifyFeedback']['userModified'] = false;
            }
        }

        // Si algún dato no es correcto, las contraseñas introducidas son diferentes o ya existe un usuario con el email o el nombre de usuario introducidos, se redirige de nuevo a la página del perfil con el parámetro GET recibido en la petición
        header('Location: ' . BASE_PATH . 'perfil.php?modificarDato=' . $_GET['modificarDato']);
        exit();

    }

}
