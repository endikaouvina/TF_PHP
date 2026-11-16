<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se incorporan las clases necesarias
require_once dirname(__DIR__) . '/core/Database.php';
require_once __DIR__ . '/User.php';

// Se define la clase 'UserDAO'
class UserDAO {

    // Se define la propiedad '$pdo', que almacenará la conexión a la BBDD
    private ?PDO $pdo;

    // Se define el método constructor de la clase, que establecerá la conexión a la BBDD y la asignará a '$pdo'
    public function __construct() {
        $this->pdo = Database::dbConnect('app/models/UserDAO.php');
    }

    // Se define el método 'UserConstruct()', que construirá un objeto de la entidad 'User' con los datos de una fila de una consulta
    private function UserConstruct(array $row): User {
        return new User(
            $row['id_user'],
            $row['nombre'],
            $row['apellidos'],
            $row['email'],
            $row['telefono'],
            $row['fecha_de_nacimiento'],
            $row['direccion'],
            $row['sexo'],
            $row['usuario'],
            $row['password_hash'],
            $row['rol']
        );
    }

    // Se define el método 'searchByEmail()', que retornará el usuario asociado al email si existe, o null si no existe
    public function searchByEmail(string $email): ?User {

        if ($this->pdo) {

            $row = null;

            try {
                $sentence = $this->pdo->prepare(
                    'SELECT user.id_user, user.nombre, user.apellidos, user.email, user.telefono, user.fecha_de_nacimiento, user.direccion, user.sexo, loginUser.usuario, loginUser.password_hash, loginUser.rol
                    FROM users_data user
                    INNER JOIN users_login loginUser
                        ON user.id_user = loginUser.id_user
                    WHERE user.email = :email'
                );

                $sentence->execute([':email' => $email]);

                $row = $sentence->fetch();
            } catch (PDOException $e) {
                return null;
            }

            if ($row === false) {
                return null;
            }

            return $this->UserConstruct($row);

        }

        return null;

    }

    // Se define el método 'searchByUserName()', que devolverá el usuario asociado al nombre de usuario si existe, o null si no existe
    public function searchByUserName(string $userName): ?User {

        if ($this->pdo) {

            $sentence = null;

            try {
                $sentence = $this->pdo->prepare(
                    'SELECT user.id_user, user.nombre, user.apellidos, user.email, user.telefono, user.fecha_de_nacimiento, user.direccion, user.sexo, loginUser.usuario, loginUser.password_hash, loginUser.rol
                    FROM users_data user
                    INNER JOIN users_login loginUser
                        ON user.id_user = loginUser.id_user
                    WHERE loginUser.usuario = :userName'
                );
            } catch (PDOException $e) {
                Logger::registerLog('Error en la sentencia $this->pdo->prepare() en app/models/UserDAO.php->searchByUserName(). No ha sido posible obtener el listado de usuarios.' . PHP_EOL . $e, 'user');
            }

            if ($sentence) {
                $sentence->execute([':userName' => $userName]);

                $row = $sentence->fetch();

                if ($row === false) {
                    return null;
                }

                return $this->UserConstruct($row);
            }

        }

        // Si la conexión PDO es incorrecta o falla la consulta a la BBDD, se devuelve null
        Logger::registerLog('No está disponible la conexión PDO en app/models/UserDAO.php->searchByUserName(). No ha sido posible obtener el usuario.', 'user');

        return null;

    }

    // Se define el método 'createUser()', que permite registrarse a un usuario
    public function registerUser(User $user): ?bool {

        if ($this->pdo) {

            // Se realiza mediante una transacción, que permite deshacer los cambios si falla alguno de los pasos
            try {

                $this->pdo->beginTransaction();
                $idUser = '0';

                // Se insertan los datos del usuario en la tabla 'users_data' y se recupera el id que se le ha asignado
                try {
                    $sentence1 = $this->pdo->prepare(
                        'INSERT INTO users_data
                            (nombre, apellidos, email, telefono, fecha_de_nacimiento, direccion, sexo)
                        VALUES
                            (:dataName, :surname, :email, :tel, :birth, :dataAddress, :sex)'
                    );

                    $sentence1->execute([
                        ':dataName' => $user->getName(),
                        ':surname' => $user->getSurname(),
                        ':email' => $user->getEmail(),
                        ':tel' => $user->getTel(),
                        ':birth' => $user->getBirth(),
                        ':dataAddress' => $user->getAddress(),
                        ':sex' => $user->getSex()
                    ]);

                    if ($sentence1->rowCount() > 0) {
                        $idUser = $this->pdo->lastInsertId();
                    }
                } catch (PDOException $e) {
                    return null;
                }

                // Si ha habido algún error en la inserción y no se ha podido obtener el id, se lanza un error
                if ($idUser === '0') {
                    throw new Exception();
                }

                // Se insertan los datos de inicio de sesión en la tabla 'users_login'
                $sentence2 = null;

                try {
                    $sentence2 = $this->pdo->prepare(
                        'INSERT INTO users_login
                            (id_user, usuario, password_hash, rol)
                        VALUES
                            (:idUser, :userName, :passwordHash, :rol)'
                    );

                    $sentence2->execute([
                        ':idUser' => $idUser,
                        ':userName' => $user->getUserName(),
                        ':passwordHash' => $user->getPasswordHash(),
                        ':rol' => $user->getRol()
                    ]);
                } catch (PDOException $e) {
                    return null;
                }

                // Si ha habido algún error en la inserción, se lanza un error
                if (!$sentence2->rowCount() > 0) {
                    throw new Exception();
                }

                // Si se han completado todos los pasos, se confirman los cambios y se retorna true
                $this->pdo->commit();
                return true;

            } catch (Exception $e) {

                // Si ha fallado algún paso, se deshacen los cambios y se retorna null
                $this->pdo->rollBack();
                return null;

            }

        }

        return null;

    }

}
