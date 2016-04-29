-- Tablas para Amauto Imperial
-- (c) George A. Garro
-- Nombres con mayúscula inical y separados con guión bajo (_).
-- Atributos en minúsculas y separados con guión bajo (_).
-- Atributo Id de clave foránea: id+Nombre_Tabla.
-- Las palabras no poseen caracteres especiales.

-- INICIO DINERARIO
CREATE TABLE Pasarela(
	id int NOT NULL PRIMARY KEY auto_increment,
	nombre varchar(32) NOT NULL UNIQUE,
	descripcion varchar(150) NULL
);

CREATE TABLE Finanza(
	id int NOT NULL PRIMARY KEY auto_increment,
	idPasarela int NOT NULL,
	monto decimal(5,2) NOT NULL,
	fecha datetime NOT NULL,
	status boolean NOT NULL,
	motivo varchar(150) NULL
);
-- FIN DINERARIO

-- INICIO USUARIO
CREATE TABLE Usuario(
	id int NOT NULL PRIMARY KEY auto_increment,
	nombre varchar(32) NOT NULL,
	apellido varchar(32) NOT NULL,
	email varchar(100) NOT NULL UNIQUE,
	clave varchar NOT NULL,
	status boolean NOT NULL DEFAULT 0,
	nivel smallint NOT NULL DEFAULT 10
);

CREATE TABLE Usuario_Meta(
	id int NOT NULL PRIMARY KEY auto_increment,
	idUsuario int NOT NULL,
	fecha_registro date NOT NULL,
	imagen varchar(350) NOT NULL DEFAULT 'email',
	genero boolean NOT NULL DEFAULT 1,
	codigo_activacion char(11) NOT NULL DEFAULT '20600404831',
	biografia varchar(450) NULL,
);

CREATE TABLE Usuario_Acceso(
	id int NOT NULL PRIMARY KEY auto_increment,
	idUsuario int NOT NULL,
	fecha_ultima datetime NOT NULL DEFAULT '1994-04-11 02:20',
	fecha_actual datetime NOT NULL DEFAULT '1994-07-14 09:20'
);

CREATE TABLE Usuario_Preferencia(
	id int NOT NULL PRIMARY KEY auto_increment,
	idUsuario int NOT NULL,
	preferencia varchar(24) NOT NULL,
	valor varchar(24) NOT NULL
);
-- FIN USUARIO


-- INICIO CURSO
CREATE TABLE Curso(
	id int NOT NULL PRIMARY KEY auto_increment,
	nombre varchar(150) NOT NULL,
	descripcion text NOT NULL,
	extracto text NULL,
	curso_padre int NOT NULL DEFAULT 0,
	status boolean NOT NULL DEFAULT 1
);

CREATE TABLE Curso_Meta(
	id int NOT NULL PRIMARY KEY auto_increment,
	idCurso int NOT NULL,
	precio decimal(4,2) NOT NULL DEFAULT 9000.50,
	imagen varchar(350) NULL,
	fecha_inicio datetime NOT NULL
);

CREATE TABLE Taxonomia(
	id int NOT NULL PRIMARY KEY auto_increment,
	nombre varchar(16) NOT NULL,
	descripcion varchar(350) NULL,
	taxonomia_padre int NOT NULL DEFAULT 1,
	orden int NULL DEFAULT 0,
	cantidad int NOT NULL
);

CREATE TABLE Curso_Taxonomia(
	id int NOT NULL PRIMARY KEY auto_increment,
	idCurso int NOT NULL,
	idTaxonomia int NOT NULL
);
-- FIN CURSO

-- INICIO MATRÍCULA
CREATE TABLE Registro_Matricula(
	id int NOT NULL PRIMARY KEY auto_increment,
	idFinanza int NOT NULL,
	idUsuario int nOT NULL,
	idCurso int NOT NULL,
	rol tinyint(1) NOT NULL,
	status boolean NOT NULL
);
-- FIN MATRÍCULA

-- INICIO PUBLICACIÓN
CREATE TABLE Publicacion(
	id int NOT NULL PRIMARY KEY auto_increment,
	idPublicacion_Remota int NOT NULL,
	publicacion_padre int NOT NULL DEFAULT 0,
	tipo int NOT NULL,
	status_comentario boolean DEFAULT 0,
	fecha_creacion datetime NOT NULL
);
-- FIN PUBLICACIÓN

-- INICIO CUESTIONARIO
CREATE TABLE Cuestionario_Uno(
	id int NOT NULL PRIMARY KEY auto_increment,
	respuesta char(1) NOT NULL,
	proposicion varchar(350) NOT NULL,
	a varchar(24) NOT NULL,
	b varchar(24) NOT NULL,
	c varchar(24) NULL,
	d varchar(24) NULL,
	e varchar(24) NULL
);

CREATE TABLE Cuestionario_Multi(
	id int NOT NULL PRIMARY KEY auto_increment,
	proposicion varchar(350) NOT NULL,
	a varchar(24) NOT NULL,
	a_correcto boolean NOT NULL,
	b varchar(24) NOT NULL,
	b_correcto boolean NOT NULL,
	c varchar(24) NULL,
	c_correcto boolean NULL,
	d varchar(24) NULL,
	d_correcto boolean NULL,
	e varchar(24) NULL,
	e_correcto boolean NULL,
);

CREATE TABLE Cuestionario_VF(
	id int NOT NULL PRIMARY KEY auto_increment,
	respuesta boolean NOT NULL,
	proposicion varchar(350) NOT NULL
);
-- FIN CUESTIONARIO

-- INICIO COMENTARIO
CREATE TABLE Comentario(
	id int NOT NULL PRIMARY KEY auto_increment,
	idPublicacion int NOT NULL,
	idUsuario int NOT NULL,
	texto text NOT NULL,
	fecha datetime NOT NULL,
	status boolean NOT NULL DEFAULT 1,
	comentario_padre int NOT NULL DEFAULT 0
);
-- FIN COMENTARIO

-- INICIO NOTAS
CREATE TABLE Acreditacion(
	id int NOT NULL PRIMARY KEY auto_increment,
	idUsuario int NOT NULL,
	idPublicacion int NOT NULL,
	puntaje decimal(5,2) NOT NULL,
	fecha datetime NOT NULL
);
-- FIN NOTAS
