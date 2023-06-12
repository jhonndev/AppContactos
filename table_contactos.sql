CREATE DATABASE dbo_contactos;

use dbo_contactos;

CREATE TABLE contactos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellidos VARCHAR(50),
    telefono VARCHAR(20) NOT NULL,
    correo VARCHAR(50) NOT NULL,
    foto VARCHAR(255),
    PRIMARY KEY (id),
    UNIQUE KEY telefono_unique (telefono),
    UNIQUE KEY correo_unique (correo)
);
