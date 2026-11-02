/* Se crea la base de datos 'tf_php' */
CREATE DATABASE IF NOT EXISTS tf_php CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci;

/* Se selecciona la base de datos */
USE tf_php;

/* Se crea la tabla 'users_data' */
CREATE TABLE users_data (
    id_user INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(30) NOT NULL,
    fecha_de_nacimiento DATE NOT NULL,
    direccion VARCHAR(255),
    sexo ENUM('Hombre', 'Mujer', 'No indicado'),
    PRIMARY KEY (id_user)
) ENGINE = InnoDB;

/* Se crea la tabla 'users_login' */
CREATE TABLE users_login (
    id_login INT AUTO_INCREMENT NOT NULL,
    id_user INT NOT NULL UNIQUE,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'user') NOT NULL,
    PRIMARY KEY (id_login),
    FOREIGN KEY (id_user) REFERENCES users_data (id_user)
) ENGINE = InnoDB;

/* Se crea la tabla 'citas' */
CREATE TABLE citas (
    id_cita INT AUTO_INCREMENT NOT NULL,
    id_user INT NOT NULL,
    fecha_cita DATETIME NOT NULL,
    motivo_cita VARCHAR(1000),
    PRIMARY KEY (id_cita),
    FOREIGN KEY (id_user) REFERENCES users_data (id_user)
) ENGINE = InnoDB;

/* Se crea la tabla 'noticias' */
CREATE TABLE noticias (
    id_noticia INT AUTO_INCREMENT NOT NULL,
    titulo VARCHAR(255) NOT NULL UNIQUE,
    imagen VARCHAR(255) NOT NULL,
    texto LONGTEXT NOT NULL,
    fecha DATETIME NOT NULL,
    id_user INT NOT NULL,
    PRIMARY KEY (id_noticia),
    FOREIGN KEY (id_user) REFERENCES users_data (id_user)
) ENGINE = InnoDB;
