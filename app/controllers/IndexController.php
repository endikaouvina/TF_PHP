<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la clase 'IndexController'
class IndexController {

    // Se define el método 'showIndex()', que mostrará la página de inicio
    public function showIndex(): void {

        // Se carga la vista de inicio
        require dirname(__DIR__) . '/views/index_view.php';
    }

}
