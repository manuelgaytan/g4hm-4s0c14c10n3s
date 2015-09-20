/*DROP DATABASE asociaciones;*/

CREATE DATABASE asociaciones
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_spanish_ci;

USE asociaciones;
/*
CREATE TABLE ItemsAsociadosIntegrantes
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
descripcion VARCHAR(255),
PRIMARY KEY (id)
);

CREATE TABLE EstadoRequisito
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
PRIMARY KEY (id)
);
*/
CREATE TABLE Asociacion
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    domicilio VARCHAR(255),
    contacto VARCHAR(255) NOT NULL,
    telefono VARCHAR(80),
    correo_electronico VARCHAR(120),
    PRIMARY KEY (id)
);
/*
CREATE TABLE UsuariosRootAsociaciones
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
fk_asociacion INT(11) UNSIGNED NOT NULL,
fk_usuario INT(11) UNSIGNED NOT NULL UNIQUE,
PRIMARY KEY (id)
);
*/
CREATE TABLE Usuario
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    usuario VARCHAR(20) NOT NULL,
    contrasena VARCHAR(20) NOT NULL,
    fecha_ultimo_acceso DATE,
    root_asociacion BOOL,
    PRIMARY KEY (id)
);

CREATE TABLE Integrante_Asociacion
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    fk_asociacion INT(11) UNSIGNED NOT NULL,
    fk_integrante INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Integrante
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    fk_usuario INT(11) UNSIGNED,
    nombre VARCHAR(120) NOT NULL,
    apellido_paterno VARCHAR(120),
    apellido_materno VARCHAR(120),
    fecha_nacimiento DATE,
    rfc VARCHAR(13),
    curp VARCHAR(18),
    domicilio VARCHAR(255),
    estado_civil VARCHAR(50),
    correo_electronico VARCHAR(120),
    ocupacion VARCHAR(255),
    quien_recomienda VARCHAR(255),
    observaciones VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE Proyecto
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    nombre VARCHAR(120) NOT NULL,
    descripcion VARCHAR(255),
    contacto VARCHAR(255) NOT NULL,
    telefono VARCHAR(80),
    correo_electronico VARCHAR(120),
    fecha_alta DATE NOT NULL,
    fecha_inicio DATE,
    fecha_fin DATE,
    fk_asociacion INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Integrante_Proyecto
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,    
    fk_integrante INT(11) UNSIGNED NOT NULL,
    fk_proyecto INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Item
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    nombre VARCHAR(255) NOT NULL,
    responsable VARCHAR(255) NOT NULL,
    descripcion VARCHAR(255),
    fk_item_aportacion INT(11) UNSIGNED,
    fk_item_requisitos INT(11) UNSIGNED,
    fk_proyecto INT(11) UNSIGNED NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Item_Aportacion
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    monto DECIMAL,
    fecha_inicio DATE,
    fecha_fin DATE,
    PRIMARY KEY (id)
);

CREATE TABLE Aportacion
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    fk_item INT(11) UNSIGNED NOT NULL,
    fk_integrante INT(11) UNSIGNED NOT NULL,
    monto DECIMAL,
    fecha DATE,
    nota VARCHAR(255),
    PRIMARY KEY (id)
);

CREATE TABLE Tipo_Item
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    nombre VARCHAR(120) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE Aviso
(
    id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
    fk_asociacion INT(11) UNSIGNED NOT NULL,
    aviso VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    fecha_alta DATE NOT NULL,
    fecha_vigencia DATE,
    PRIMARY KEY (id)
);
    
/*
CREATE TABLE IntegrantesAsociacionIntegrantes
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
fk_integrante_asociacion INT(11) UNSIGNED NOT NULL,
fk_proyecto INT(11) UNSIGNED NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE Requisitos
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
PRIMARY KEY (id)
);

CREATE TABLE IntegrantesRequisitos
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
fk_proyecto INT(11) UNSIGNED NOT NULL,
fk_requisitos INT(11) UNSIGNED NOT NULL,
PRIMARY KEY (id)
);

CREATE TABLE IntegrantesAsociacionIntegrantesIntegrantesRequisitos
(
id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT UNIQUE,
fk_integrante_asociacion_proyecto INT(11) UNSIGNED NOT NULL,
fk_proyecto_requisito INT(11) UNSIGNED NOT NULL,
fk_estado_requisito INT(11) UNSIGNED NOT NULL,
PRIMARY KEY (id)
);

ALTER TABLE UsuariosRootAsociaciones ADD FOREIGN KEY fk_asociacion_idxfk (fk_asociacion) REFERENCES Asociaciones (id);

ALTER TABLE Usuarios ADD FOREIGN KEY id_idxfk (id) REFERENCES UsuariosRootAsociaciones (fk_usuario);
*/
ALTER TABLE Integrante_Asociacion ADD FOREIGN KEY fk_asociacion_idxfk_1 (fk_asociacion) REFERENCES Asociacion (id);

ALTER TABLE Integrante_Asociacion ADD FOREIGN KEY fk_integrante_idxfk_1 (fk_integrante) REFERENCES Integrante (id);

ALTER TABLE Integrante ADD FOREIGN KEY fk_usuario_idxfk_1 (fk_usuario) REFERENCES Usuario (id);

ALTER TABLE Proyecto ADD FOREIGN KEY fk_asociacion_idxfk_2 (fk_asociacion) REFERENCES Asociacion (id);

ALTER TABLE Item ADD FOREIGN KEY fk_proyecto_idxfk_1 (fk_proyecto) REFERENCES Proyecto (id);

ALTER TABLE Item ADD FOREIGN KEY fk_item_aportacion_idxfk_1 (fk_item_aportacion) REFERENCES Item_Aportacion (id);

ALTER TABLE Aportacion ADD FOREIGN KEY fk_item_idxfk_1 (fk_item) REFERENCES Item (id);

ALTER TABLE Aportacion ADD FOREIGN KEY fk_integrante_idxfk_2 (fk_integrante) REFERENCES Integrante (id);

ALTER TABLE Integrante_Proyecto ADD FOREIGN KEY fk_integrante_idxfk_3 (fk_integrante) REFERENCES Integrante (id);

ALTER TABLE Integrante_Proyecto ADD FOREIGN KEY fk_proyecto_idxfk_2 (fk_proyecto) REFERENCES Proyecto (id);

ALTER TABLE Aviso ADD FOREIGN KEY fk_asociacion_idxfk_3 (fk_asociacion) REFERENCES Asociacion (id);
/*
ALTER TABLE Item ADD FOREIGN KEY fk_item_requisitos_idxfk_1 (fk_item_requisitos) REFERENCES ItemRequisitos (id);
*/

/*
ALTER TABLE Integrantes ADD FOREIGN KEY fk_asociacion_idxfk_2 (fk_asociacion) REFERENCES Asociaciones (id);

ALTER TABLE IntegrantesItemsAsociadosIntegrantes ADD FOREIGN KEY fk_item_asociado_proyecto_idxfk (fk_item_asociado_proyecto) REFERENCES ItemsAsociadosIntegrantes (id);

ALTER TABLE IntegrantesItemsAsociadosIntegrantes ADD FOREIGN KEY fk_proyecto_idxfk (fk_proyecto) REFERENCES Integrantes (id);

ALTER TABLE Aportacion ADD FOREIGN KEY fk_proyecto_idxfk_1 (fk_proyecto) REFERENCES Integrantes (id);

ALTER TABLE IntegrantesAsociacionIntegrantes ADD FOREIGN KEY fk_integrante_asociacion_idxfk (fk_integrante_asociacion) REFERENCES IntegrantesAsociacion (id);

ALTER TABLE IntegrantesAsociacionIntegrantes ADD FOREIGN KEY fk_proyecto_idxfk_2 (fk_proyecto) REFERENCES Integrantes (id);

ALTER TABLE TransaccionAportacion ADD FOREIGN KEY fk_aportacion_idxfk (fk_aportacion) REFERENCES Aportacion (id);

ALTER TABLE TransaccionAportacion ADD FOREIGN KEY fk_integrante_asociacion_idxfk_1 (fk_integrante_asociacion) REFERENCES IntegrantesAsociacionIntegrantes (id);

ALTER TABLE IntegrantesRequisitos ADD FOREIGN KEY fk_proyecto_idxfk_3 (fk_proyecto) REFERENCES Integrantes (id);

ALTER TABLE IntegrantesRequisitos ADD FOREIGN KEY fk_requisitos_idxfk (fk_requisitos) REFERENCES Requisitos (id);

ALTER TABLE IntegrantesAsociacionIntegrantesIntegrantesRequisitos ADD FOREIGN KEY fk_integrante_asociacion_proyecto_idxfk (fk_integrante_asociacion_proyecto) REFERENCES IntegrantesAsociacionIntegrantes (id);

ALTER TABLE IntegrantesAsociacionIntegrantesIntegrantesRequisitos ADD FOREIGN KEY fk_proyecto_requisito_idxfk (fk_proyecto_requisito) REFERENCES IntegrantesRequisitos (id);

ALTER TABLE IntegrantesAsociacionIntegrantesIntegrantesRequisitos ADD FOREIGN KEY fk_estado_requisito_idxfk (fk_estado_requisito) REFERENCES EstadoRequisito (id);
*/

INSERT INTO Asociacion (id, nombre, contacto)
	VALUES (1, 'Azcapotzalco Unido A.C.', 'Lic. Ignacion Huerta');
INSERT INTO Asociacion (id, nombre, contacto)
	VALUES (2, 'Asamblea de Barrios A.C.', 'Sra. Beatriz');

INSERT INTO Usuario (id, usuario, contrasena)
	VALUES (1, 'test', 'test');
INSERT INTO Usuario (id, usuario, contrasena, root_asociacion)
	VALUES (2, 'admin', 'notiene', true);
INSERT INTO Usuario (id, usuario, contrasena)
	VALUES (3, 'root', 'notiene');

INSERT INTO Integrante (id, nombre, apellido_paterno, fk_usuario)
	VALUES (1, 'Manuel','GaytÃ¡n', 1);
INSERT INTO Integrante (id, nombre, apellido_paterno, fk_usuario)
	VALUES (2, 'Israel','Miranda', NULL);
INSERT INTO Integrante (id, nombre, apellido_paterno, fk_usuario)
	VALUES (3, 'Daniel','Miranda', NULL);
INSERT INTO Integrante (id, nombre, apellido_paterno, fk_usuario)
	VALUES (4, 'Ignacio','Morales', 2);

INSERT INTO Integrante_Asociacion (id, fk_asociacion, fk_integrante)
	VALUES (1, 1, 1);
INSERT INTO Integrante_Asociacion (id, fk_asociacion, fk_integrante)
	VALUES (2, 1, 2);
INSERT INTO Integrante_Asociacion (id, fk_asociacion, fk_integrante)
	VALUES (3, 1, 3);
INSERT INTO Integrante_Asociacion (id, fk_asociacion, fk_integrante)
	VALUES (4, 2, 2);
INSERT INTO Integrante_Asociacion (id, fk_asociacion, fk_integrante)
	VALUES (5, 2, 3);

INSERT INTO Proyecto (id, nombre, contacto, fecha_alta, fk_asociacion)
	VALUES (1, 'Departamentos Rayon 71', 'Lic. Ignacio Huerta', '2014-10-30', 1);
INSERT INTO Proyecto (id, nombre, contacto, fecha_alta, fk_asociacion)
	VALUES (2, 'Departamentos San Isidro', 'Lic. Ignacio Huerta', '2014-10-29', 1);
INSERT INTO Proyecto (id, nombre, contacto, fecha_alta, fk_asociacion)
	VALUES (3, 'Departamentos General Anaya', 'Sra. Beatriz', '2013-02-14', 2);
INSERT INTO Proyecto (id, nombre, contacto, fecha_alta, fk_asociacion)
	VALUES (4, 'Apoyo a la Vivienda', 'Lic. DÃ¡vila', '2014-08-01', 2);

INSERT INTO Tipo_Item
	VALUES (1, 'AportaciÃ³n');
INSERT INTO Tipo_Item
	VALUES (2, 'Requisitos');
