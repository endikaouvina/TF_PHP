<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se prepara el entorno del proyecto
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/debug.php';

// Si ya existe un usuario con la sesión iniciada, se le redirige a la página de inicio
if (Auth::isLogin()) {
    header('Location: ' . BASE_PATH);
    exit();
}

// Se incluye el controlador de autenticación
require_once dirname(__DIR__) . '/app/controllers/AuthController.php';

// Se pone en marcha el controlador
$controller = new AuthController();

// Si se ha enviado el formulario (POST), se procesa; sino, se muestra el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->login();
} else {
    $controller->showLogin();
}
