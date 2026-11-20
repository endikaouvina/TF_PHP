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

    // Se define el método 'searchById()', que retornará el usuario asociado al id si existe, o null si no existe o ha habido algún error
    public function searchById(int $id): ?User {

        if ($this->pdo) {

            $row = null;

            try {
                $sentence = $this->pdo->prepare(
                    'SELECT user.id_user, user.nombre, user.apellidos, user.email, user.telefono, user.fecha_de_nacimiento, user.direccion, user.sexo, loginUser.usuario, loginUser.password_hash, loginUser.rol
                    FROM users_data user
                    INNER JOIN users_login loginUser
                        ON user.id_user = loginUser.id_user
                    WHERE user.id_user = :id'
                );

                $sentence->execute([':id' => $id]);

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

    // Se define el método 'searchByEmail()', que retornará el usuario asociado al email si existe, o null si no existe o ha habido algún error
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

    // Se define el método 'searchByUserName()', que devolverá el usuario asociado al nombre de usuario si existe, o null si no existe o ha habido algún error
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
                return null;
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

        // Si la conexión PDO es incorrecta o falla la consulta a la BBDD, se retorna null
        return null;

    }

    // Se define el método 'registerUser()', que permite registrarse a un usuario
    public function registerUser(User $user): ?bool {

        if ($this->pdo) {

            // Se realiza mediante una transacción, que permite deshacer los cambios si falla alguno de los pasos
            try {

                $this->pdo->beginTransaction();

                // Se insertan los datos del usuario en la tabla 'users_data' y se recupera el id que se le ha asignado
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

                // Se obtiene el id creado y se guarda en la variable '$idUser' para su utilización en la inserción de datos en la tabla 'users_login'
                $idUser = $this->pdo->lastInsertId();

                // Si ha habido algún error en la inserción y no se ha podido obtener el id, se lanza un error
                if (!$idUser) {
                    throw new Exception();
                }

                // Se insertan los datos de inicio de sesión en la tabla 'users_login'
                $sentence2 = $this->pdo->prepare(
                    'INSERT INTO users_login
                        (id_user, usuario, password_hash, rol)
                    VALUES
                        (:idUser, :userName, :passHash, :rol)'
                );

                $sentence2->execute([
                    ':idUser' => $idUser,
                    ':userName' => $user->getUserName(),
                    ':passHash' => $user->getPassHash(),
                    ':rol' => $user->getRol()
                ]);

                // Si se han completado todos los pasos correctamente, se confirman los cambios y se retorna true
                $this->pdo->commit();
                return true;

            } catch (Exception $e) {

                // Si ha fallado algún paso, se deshacen los cambios y se retorna null
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }

                return null;

            }

        }

        return null;

    }

    // Se define el método 'modifyUser()', que permite modificar un usuario de la BBDD
    public function modifyUser(User $user): ?bool {

        if ($this->pdo) {

            // Se realiza mediante una transacción, que permite deshacer los cambios si falla alguno de los pasos
            try {

                $this->pdo->beginTransaction();

                // Se modifican los datos del usuario en la tabla 'users_data'
                $sentence1 = $this->pdo->prepare(
                    'UPDATE users_data SET
                        nombre = :dataName,
                        apellidos = :surname,
                        email = :email,
                        telefono = :tel,
                        fecha_de_nacimiento = :birth,
                        direccion = :dataAddress,
                        sexo = :sex
                    WHERE id_user = :id'
                );

                $sentence1->execute([
                    ':dataName' => $user->getName(),
                    ':surname' => $user->getSurname(),
                    ':email' => $user->getEmail(),
                    ':tel' => $user->getTel(),
                    ':birth' => $user->getBirth(),
                    ':dataAddress' => $user->getAddress(),
                    ':sex' => $user->getSex(),
                    ':id' => $user->getId()
                ]);

                // Se modifican los datos de inicio de sesión en la tabla 'users_login'
                $sentence2 = $this->pdo->prepare(
                    'UPDATE users_login SET
                        usuario = :userName,
                        password_hash = :passHash,
                        rol = :rol
                    WHERE id_user = :id'
                );

                $sentence2->execute([
                    ':userName' => $user->getUserName(),
                    ':passHash' => $user->getPassHash(),
                    ':rol' => $user->getRol(),
                    ':id' => $user->getId()
                ]);

                // Si se han completado todos los pasos correctamente, se confirman los cambios y se retorna true
                $this->pdo->commit();
                return true;

            } catch (Exception $e) {

                // Si ha fallado algún paso, se deshacen los cambios y se retorna null
                if ($this->pdo->inTransaction()) {
                    $this->pdo->rollBack();
                }

                return null;

            }

        }

        return null;

    }

}
