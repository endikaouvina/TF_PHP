<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se prepara el entorno del proyecto
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/debug.php';

// Si no existe un usuario con la sesión iniciada, se le redirige a la página de login
if (!Auth::isLogin()) {
    header('Location: ' . BASE_PATH . 'login.php');
    exit();
}

// Se incluye el controlador de la página del perfil
require_once dirname(__DIR__) . '/app/controllers/ProfileController.php';

// Se pone en marcha el controlador
$controller = new ProfileController();

// Si se ha enviado el formulario (POST), se procesa; sino, se muestran los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->modifyProfile();
} else {
    $controller->showProfile();
}
