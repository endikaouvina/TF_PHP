<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las clases necesarias
require_once dirname(__DIR__) . '/core/Database.php';
require_once __DIR__ . '/News.php';

// Se define la clase 'NewsDAO'
class NewsDAO {

    // Se define la propiedad '$pdo', que almacenará la conexión a la BBDD
    private ?PDO $pdo;

    // Se define el método constructor de la clase, que establecerá la conexión a la BBDD y la asignará a '$pdo'
    public function __construct() {
        $this->pdo = Database::dbConnect('app/models/NewsDAO.php');
    }

    // Se define el método 'newsConstruct()', que construirá un objeto de la entidad 'News' con los datos de una fila de una consulta
    private function newsConstruct(array $row): News {
        return new News(
            $row['titulo'],
            $row['imagen'],
            $row['texto'],
            $row['fecha'],
            $row['usuario']
        );
    }

    // Se define el método 'list()'
    public function list(): ?array {

        // Si la conexión PDO es correcta, se realiza la consulta
        if ($this->pdo) {

            $result = null;

            try {
                $result = $this->pdo->query(
                    'SELECT news.titulo, news.imagen, news.texto, news.fecha, user.nombre AS usuario
                    FROM noticias news
                    INNER JOIN users_data user
                        ON news.id_user = user.id_user'
                );
            } catch (PDOException $e) {
                Logger::registerLog('Error en la sentencia $this->pdo->query() en app/models/NewsDAO.php->list(). No ha sido posible obtener el listado de noticias.' . PHP_EOL . $e, 'news');
            }

            // Si la consulta es correcta, se devuelve un array con las noticias
            if ($result) {
                $news = [];

                // Se convierte cada fila en un objeto de la entidad 'News'
                foreach ($result as $row) {
                    $news[] = $this->newsConstruct($row);
                }

                return $news;
            }

        }

        // Si la conexión PDO es incorrecta o falla la consulta a la BBDD, se devuelve null
        Logger::registerLog('No está disponible la conexión PDO en app/models/NewsDAO.php->list(). No ha sido posible obtener el listado de noticias.', 'news');

        return null;

    }

}
