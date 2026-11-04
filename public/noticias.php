<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se prepara el entorno del proyecto
require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/config/debug.php';

// Se incluye el controlador de la página de noticias
require_once dirname(__DIR__) . '/app/controllers/NewsController.php';

// Se pone en marcha el controlador y se solicita la página de inicio
$controller = new NewsController();
$controller->showNews();
