DROP DATABASE asociaciones;

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
    intentos_fallidos INT(1) NOT NULL,
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

INSERT INTO Tipo_Item
	VALUES (1, 'AportaciÃ³n');
INSERT INTO Tipo_Item
	VALUES (2, 'Requisitos');


INSERT INTO Asociacion (id, nombre, contacto)
	VALUES (1, 'Azcapotzalco Unido A.C.', 'Lic. Ignacion Huerta');

INSERT INTO Proyecto (id, nombre, contacto, fecha_alta, fk_asociacion)
	VALUES (1, 'Departamentos Rayon 71', 'Lic. Ignacio Huerta', '2014-10-30', 1);

insert into usuario (id, usuario,contrasena) values (1,'cosorio','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (2,'gdeciga','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (3,'shurtado','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (4,'maldana','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (5,'pandrade','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (6,'rcalderon','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (7,'gcastizo','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (8,'icontreras','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (9,'a cornish','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (10,'gcruz','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (11,'mdavila','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (12,'fflores','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (13,'oflores','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (14,'sgarcia','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (15,'mgaytan','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (16,'mgonsalez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (17,'ahurtado','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (18,'churtado','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (19,'ichavarria','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (20,'cchavarria','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (21,'amendoza','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (22,'omelin','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (23,'gmiramar','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (24,'dmiranda','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (25,'imiranda','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (26,'emiranda','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (27,'jortega','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (28,'pordonez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (29,'ljimenez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (30,'eperez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (31,'arueda','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (32,'ctorres','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (33,'mtorres','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (34,'svasquez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (35,'jvasquez','AsiFueLIEbV46');
insert into usuario (id, usuario,contrasena) values (36,'igonzalez','AsiFueLIEbV46');



INSERT INTO Usuario (id, usuario, contrasena, root_asociacion)
	VALUES (37, 'admin', 'notiene', true);
INSERT INTO Usuario (id, usuario, contrasena)
	VALUES (38, 'root', 'notiene');

insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (1,1,'Carmen','Osorio');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (2,2,'Gabriela','Deciga');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (3,3,'Sergio','Hurtado');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (4,4,'Mario','Aldana');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (5,5,'Paola ','Andrade');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (6,6,'Rodrigo','Calderon');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (7,7,'Guilermina','Castizo');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (8,8,'Ivan','Contreras');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (9,9,'Adriana',' Cornish');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (10,10,'Guadalupe','Cruz');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (11,11,'Maribel','Davila');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (12,12,'Fernanda','Flores');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (13,13,'Oscar','Flores');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (14,14,'Silvia','Garcia');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (15,15,'Manuel','Gaytan');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (16,16,'Marisol','Gonsalez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (17,17,'Alejandro','Hurtado');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (18,18,'Claudia','Hurtado');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (19,19,'Irene','Chavarria');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (20,20,'Carlos','Chavarria');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (21,21,'Ambrosio','Mendoza');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (22,22,'Oralia','Melin');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (23,23,'Gabriela','Miramar');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (24,24,'Daniel','Miranda');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (25,25,'Israel','Miranda');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (26,26,'Enrique','Miranda');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (27,27,'Janet','Ortega');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (28,28,'Pamela','Ordonez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (29,29,'Leticia','Jimenez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (30,30,'Enrique','Perez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (31,31,'Arnoldo','Rueda');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (32,32,'Claudia','Torres');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (33,33,'Maria','Torres');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (34,34,'Simon','Vasquez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (35,35,'Joel','Vasquez');
insert into integrante (id, fk_usuario,nombre, apellido_paterno) values (36,36,'Irma','Gonzalez');

INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 1,1);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 2,2);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 3,3);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 4,4);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 5,5);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 6,6);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 7,7);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 8,8);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 9,9);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 10,10);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 11,11);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 12,12);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 13,13);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 14,14);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 15,15);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 16,16);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 17,17);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 18,18);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 19,19);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 20,20);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 21,21);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 22,22);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 23,23);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 24,24);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 25,25);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 26,26);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 27,27);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 28,28);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 29,29);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 30,30);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 31,31);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 32,32);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 33,33);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 34,34);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 35,35);
INSERT INTO Integrante_Asociacion (fk_asociacion, id, fk_integrante) VALUES (1, 36,36);

