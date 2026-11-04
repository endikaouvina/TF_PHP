<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorpora el modelo necesario
require_once dirname(__DIR__) . '/models/NewsDAO.php';

// Se define la clase 'NewsController'
class NewsController {

    // Se define el método 'showNews()', que mostrará el listado de noticias
    public function showNews(): void {
        $newsDAO = new NewsDAO();

        // Se obtienen todas las noticias
        $news = $newsDAO->list();

        // Se entregan los datos a la vista, junto con el nombre de la página
        $pageTitle = 'Noticias | ';

        require_once dirname(__DIR__) . '/views/news_view.php';
    }

}
