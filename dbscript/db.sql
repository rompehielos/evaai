-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: dblearning
-- ------------------------------------------------------
-- Server version	5.5.47-0+deb7u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Cronograma`
--

DROP TABLE IF EXISTS `Cronograma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Cronograma` (
  `id` int(11) NOT NULL,
  `idSesion` int(11) NOT NULL,
  `idCursoFecha` int(11) NOT NULL,
  `horaInicio` time DEFAULT NULL,
  `horaFin` time DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Sesion_has_CursoFecha_CursoFecha1_idx` (`idCursoFecha`),
  KEY `fk_Sesion_has_CursoFecha_Sesion1_idx` (`idSesion`),
  CONSTRAINT `fk_Sesion_has_CursoFecha_CursoFecha1` FOREIGN KEY (`idCursoFecha`) REFERENCES `CursoFecha` (`idCursoFecha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Sesion_has_CursoFecha_Sesion1` FOREIGN KEY (`idSesion`) REFERENCES `Sesion` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Cronograma`
--

LOCK TABLES `Cronograma` WRITE;
/*!40000 ALTER TABLE `Cronograma` DISABLE KEYS */;
INSERT INTO `Cronograma` VALUES (1,1,1,'14:00:00','16:00:00'),(2,2,1,'14:00:00','16:00:00'),(3,3,1,'14:00:00','16:00:00'),(4,4,1,'14:00:00','16:00:00'),(5,5,1,'14:00:00','16:00:00'),(6,6,1,'14:00:00','16:00:00'),(7,7,1,'14:00:00','16:00:00');
/*!40000 ALTER TABLE `Cronograma` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Curso`
--

DROP TABLE IF EXISTS `Curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Curso` (
  `idCurso` int(11) NOT NULL,
  `idCursoPadre` int(11) DEFAULT NULL,
  `idModulo` int(11) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  `categoria_idcategoria` int(11) NOT NULL,
  PRIMARY KEY (`idCurso`),
  KEY `fk_Curso_Curso1_idx` (`idCursoPadre`),
  KEY `fk_Curso_Modulo1_idx` (`idModulo`),
  KEY `fk_Curso_categoria1_idx` (`categoria_idcategoria`),
  CONSTRAINT `fk_Curso_categoria1` FOREIGN KEY (`categoria_idcategoria`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Curso_Curso1` FOREIGN KEY (`idCursoPadre`) REFERENCES `Curso` (`idCurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Curso_Modulo1` FOREIGN KEY (`idModulo`) REFERENCES `Modulo` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Curso`
--

LOCK TABLES `Curso` WRITE;
/*!40000 ALTER TABLE `Curso` DISABLE KEYS */;
INSERT INTO `Curso` VALUES (1,NULL,1,'Programación Orientada a Objetos','...',0),(2,NULL,1,'Programación Cuántica','...',0),(3,NULL,1,'Programación Básica','...',0);
/*!40000 ALTER TABLE `Curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CursoFecha`
--

DROP TABLE IF EXISTS `CursoFecha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CursoFecha` (
  `idCursoFecha` int(11) NOT NULL,
  `idCurso` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `fechaInicio` date NOT NULL,
  `fechaFin` date NOT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  PRIMARY KEY (`idCursoFecha`),
  KEY `fk_CursoFecha_Curso1_idx` (`idCurso`),
  KEY `fk_CursoFecha_Usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_CursoFecha_Curso1` FOREIGN KEY (`idCurso`) REFERENCES `Curso` (`idCurso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_CursoFecha_Usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CursoFecha`
--

LOCK TABLES `CursoFecha` WRITE;
/*!40000 ALTER TABLE `CursoFecha` DISABLE KEYS */;
INSERT INTO `CursoFecha` VALUES (1,1,1,'2016-04-19','2016-05-28',1200.00);
/*!40000 ALTER TABLE `CursoFecha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Finanza`
--

DROP TABLE IF EXISTS `Finanza`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Finanza` (
  `id` int(11) NOT NULL,
  `idEstado` int(11) NOT NULL,
  `idPasarela` int(11) NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `monto` decimal(6,2) NOT NULL,
  `observacion` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Finanzas_Pasarela_idx` (`idPasarela`),
  CONSTRAINT `fk_Finanzas_Pasarela` FOREIGN KEY (`idPasarela`) REFERENCES `Pasarela` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Finanza`
--

LOCK TABLES `Finanza` WRITE;
/*!40000 ALTER TABLE `Finanza` DISABLE KEYS */;
INSERT INTO `Finanza` VALUES (1,1,1,'2016-04-19 14:00:00',1200.00,'...');
/*!40000 ALTER TABLE `Finanza` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Log`
--

DROP TABLE IF EXISTS `Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Log` (
  `id` int(11) NOT NULL,
  `ipv4` varchar(45) NOT NULL,
  `ipv6` varchar(45) DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  `navegador` varchar(45) NOT NULL,
  `clave` char(128) DEFAULT NULL,
  `operacion` varchar(45) DEFAULT NULL,
  `fechalog` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Logs_Usuario1_idx` (`idUsuario`),
  CONSTRAINT `fk_Logs_Usuario1` FOREIGN KEY (`idUsuario`) REFERENCES `Usuario` (`idUsuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Log`
--

LOCK TABLES `Log` WRITE;
/*!40000 ALTER TABLE `Log` DISABLE KEYS */;
/*!40000 ALTER TABLE `Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matricula`
--

DROP TABLE IF EXISTS `Matricula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Matricula` (
  `id` int(11) NOT NULL,
  `idFinanza` int(11) NOT NULL,
  `idCursoFecha` int(11) NOT NULL,
  `estado` char(1) DEFAULT '0' COMMENT '"0" Cancelada \n"1" Iniciada\n"2" Pagada\n"3" En ValidaciÃ³n',
  PRIMARY KEY (`id`),
  KEY `fk_dblearning_Finanzas1_idx` (`idFinanza`),
  KEY `fk_dblearning_CursoFecha1_idx` (`idCursoFecha`),
  CONSTRAINT `fk_dblearning_CursoFecha1` FOREIGN KEY (`idCursoFecha`) REFERENCES `CursoFecha` (`idCursoFecha`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_dblearning_Finanzas1` FOREIGN KEY (`idFinanza`) REFERENCES `Finanza` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matricula`
--

LOCK TABLES `Matricula` WRITE;
/*!40000 ALTER TABLE `Matricula` DISABLE KEYS */;
INSERT INTO `Matricula` VALUES (1,1,1,'1');
/*!40000 ALTER TABLE `Matricula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Modulo`
--

DROP TABLE IF EXISTS `Modulo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Modulo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Modulo`
--

LOCK TABLES `Modulo` WRITE;
/*!40000 ALTER TABLE `Modulo` DISABLE KEYS */;
INSERT INTO `Modulo` VALUES (1,'Programación','...');
/*!40000 ALTER TABLE `Modulo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Opciones`
--

DROP TABLE IF EXISTS `Opciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Opciones` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `valor` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Opciones`
--

LOCK TABLES `Opciones` WRITE;
/*!40000 ALTER TABLE `Opciones` DISABLE KEYS */;
INSERT INTO `Opciones` VALUES (1,'dominio','voz.pisfato.com'),(2,'nombre','Evaai - Entorno Virtual de Aprendizaje AI'),(3,'url','http://voz.pisfato.com');
/*!40000 ALTER TABLE `Opciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pasarela`
--

DROP TABLE IF EXISTS `Pasarela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pasarela` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pasarela`
--

LOCK TABLES `Pasarela` WRITE;
/*!40000 ALTER TABLE `Pasarela` DISABLE KEYS */;
INSERT INTO `Pasarela` VALUES (1,'Pago Efectivo','...'),(2,'Pay Pal','...');
/*!40000 ALTER TABLE `Pasarela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recurso`
--

DROP TABLE IF EXISTS `Recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recurso` (
  `id` int(11) NOT NULL,
  `idCronograma` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(2083) DEFAULT NULL,
  `url` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Recurso_Cronograma2_idx` (`idCronograma`),
  CONSTRAINT `fk_Recurso_Cronograma2` FOREIGN KEY (`idCronograma`) REFERENCES `Cronograma` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recurso`
--

LOCK TABLES `Recurso` WRITE;
/*!40000 ALTER TABLE `Recurso` DISABLE KEYS */;
/*!40000 ALTER TABLE `Recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rol`
--

DROP TABLE IF EXISTS `Rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rol` (
  `idRol` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`idRol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rol`
--

LOCK TABLES `Rol` WRITE;
/*!40000 ALTER TABLE `Rol` DISABLE KEYS */;
INSERT INTO `Rol` VALUES (1,'Administrador');
/*!40000 ALTER TABLE `Rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Sesion`
--

DROP TABLE IF EXISTS `Sesion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Sesion` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` varchar(400) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Sesion`
--

LOCK TABLES `Sesion` WRITE;
/*!40000 ALTER TABLE `Sesion` DISABLE KEYS */;
INSERT INTO `Sesion` VALUES (1,'Abstracción',''),(2,'Encapsulamiento',''),(3,'Polimorfismo',''),(4,'Herencia',''),(5,'Modularidad',''),(6,'Principio de Ocultación',''),(7,'Recolección de Basura','');
/*!40000 ALTER TABLE `Sesion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuario` (
  `idUsuario` int(11) NOT NULL,
  `idUsuarioMeta` int(11) NOT NULL,
  `idRol` int(11) NOT NULL,
  `apellido` varchar(24) NOT NULL,
  `nombre` varchar(24) NOT NULL,
  `correo` varchar(256) NOT NULL,
  `alias` varchar(16) NOT NULL,
  `clave` char(128) NOT NULL,
  `estado` char(1) DEFAULT '0' COMMENT '"0" Inactivo\n"1" Activo',
  PRIMARY KEY (`idUsuario`),
  KEY `fk_Usuario_Rol1_idx` (`idRol`),
  KEY `fk_Usuario_UsuarioMeta1_idx` (`idUsuarioMeta`),
  CONSTRAINT `fk_Usuario_Rol1` FOREIGN KEY (`idRol`) REFERENCES `Rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Usuario_UsuarioMeta1` FOREIGN KEY (`idUsuarioMeta`) REFERENCES `UsuarioMeta` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,1,1,'Gates','Steve','steve@gates','steve','jobs','1'),(2,1,1,'Jobs','Bill','jobs@bill','bill','gates','1');
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UsuarioMeta`
--

DROP TABLE IF EXISTS `UsuarioMeta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UsuarioMeta` (
  `id` int(11) NOT NULL,
  `genero` varchar(45) DEFAULT NULL,
  `codigoActivacion` varchar(45) NOT NULL,
  `biografia` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UsuarioMeta`
--

LOCK TABLES `UsuarioMeta` WRITE;
/*!40000 ALTER TABLE `UsuarioMeta` DISABLE KEYS */;
INSERT INTO `UsuarioMeta` VALUES (1,'0','1','Steve Gates');
/*!40000 ALTER TABLE `UsuarioMeta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `beneficio`
--

DROP TABLE IF EXISTS `beneficio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `beneficio` (
  `idbeneficio` int(11) NOT NULL,
  `bene_descrip` varchar(40) NOT NULL,
  `motivo_beneficio_idmotivo_beneficio` int(11) NOT NULL,
  PRIMARY KEY (`idbeneficio`),
  UNIQUE KEY `idbeneficio_UNIQUE` (`idbeneficio`),
  UNIQUE KEY `bene_descrip_UNIQUE` (`bene_descrip`),
  KEY `fk_beneficio_motivo_beneficio1_idx` (`motivo_beneficio_idmotivo_beneficio`),
  CONSTRAINT `fk_beneficio_motivo_beneficio1` FOREIGN KEY (`motivo_beneficio_idmotivo_beneficio`) REFERENCES `motivo_beneficio` (`idmotivo_beneficio`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `beneficio`
--

LOCK TABLES `beneficio` WRITE;
/*!40000 ALTER TABLE `beneficio` DISABLE KEYS */;
/*!40000 ALTER TABLE `beneficio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `cat_descrip` varchar(20) NOT NULL,
  PRIMARY KEY (`idcategoria`),
  UNIQUE KEY `cat_descrip_UNIQUE` (`cat_descrip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ciclo`
--

DROP TABLE IF EXISTS `ciclo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciclo` (
  `idciclo` int(11) NOT NULL,
  `cicl_descrip` varchar(6) NOT NULL,
  PRIMARY KEY (`idciclo`),
  UNIQUE KEY `cicl_descrip_UNIQUE` (`cicl_descrip`),
  UNIQUE KEY `idciclo_UNIQUE` (`idciclo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ciclo`
--

LOCK TABLES `ciclo` WRITE;
/*!40000 ALTER TABLE `ciclo` DISABLE KEYS */;
/*!40000 ALTER TABLE `ciclo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curricula`
--

DROP TABLE IF EXISTS `curricula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curricula` (
  `idcurricula` int(11) NOT NULL,
  `curri_descrip` varchar(45) NOT NULL,
  PRIMARY KEY (`idcurricula`),
  UNIQUE KEY `curri_descrip_UNIQUE` (`curri_descrip`),
  UNIQUE KEY `idcurricula_UNIQUE` (`idcurricula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curricula`
--

LOCK TABLES `curricula` WRITE;
/*!40000 ALTER TABLE `curricula` DISABLE KEYS */;
/*!40000 ALTER TABLE `curricula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escuela`
--

DROP TABLE IF EXISTS `escuela`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escuela` (
  `idescuela` int(11) NOT NULL,
  `escu_descrip` varchar(45) NOT NULL,
  `facultad_idfacultad` int(11) NOT NULL,
  PRIMARY KEY (`idescuela`),
  UNIQUE KEY `escu_descrip_UNIQUE` (`escu_descrip`),
  UNIQUE KEY `idescuela_UNIQUE` (`idescuela`),
  KEY `fk_escuela_facultad1_idx` (`facultad_idfacultad`),
  CONSTRAINT `fk_escuela_facultad1` FOREIGN KEY (`facultad_idfacultad`) REFERENCES `facultad` (`idfacultad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escuela`
--

LOCK TABLES `escuela` WRITE;
/*!40000 ALTER TABLE `escuela` DISABLE KEYS */;
/*!40000 ALTER TABLE `escuela` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estado`
--

DROP TABLE IF EXISTS `estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estado` (
  `idestado` int(11) NOT NULL,
  `est_descrip` varchar(45) NOT NULL,
  PRIMARY KEY (`idestado`),
  UNIQUE KEY `est_descrip_UNIQUE` (`est_descrip`),
  UNIQUE KEY `idestado_UNIQUE` (`idestado`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estado`
--

LOCK TABLES `estado` WRITE;
/*!40000 ALTER TABLE `estado` DISABLE KEYS */;
/*!40000 ALTER TABLE `estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `facultad`
--

DROP TABLE IF EXISTS `facultad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `facultad` (
  `idfacultad` int(11) NOT NULL,
  `facu_descrip` varchar(40) NOT NULL,
  PRIMARY KEY (`idfacultad`),
  UNIQUE KEY `idfacultad_UNIQUE` (`idfacultad`),
  UNIQUE KEY `facu_descrip_UNIQUE` (`facu_descrip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `facultad`
--

LOCK TABLES `facultad` WRITE;
/*!40000 ALTER TABLE `facultad` DISABLE KEYS */;
/*!40000 ALTER TABLE `facultad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modalidad_estudio`
--

DROP TABLE IF EXISTS `modalidad_estudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modalidad_estudio` (
  `idmodalidad_estudio` int(11) NOT NULL,
  `modestu_decrip` varchar(45) NOT NULL,
  PRIMARY KEY (`idmodalidad_estudio`),
  UNIQUE KEY `modestu_decrip_UNIQUE` (`modestu_decrip`),
  UNIQUE KEY `idmodalidad_estudio_UNIQUE` (`idmodalidad_estudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modalidad_estudio`
--

LOCK TABLES `modalidad_estudio` WRITE;
/*!40000 ALTER TABLE `modalidad_estudio` DISABLE KEYS */;
/*!40000 ALTER TABLE `modalidad_estudio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `motivo_beneficio`
--

DROP TABLE IF EXISTS `motivo_beneficio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `motivo_beneficio` (
  `idmotivo_beneficio` int(11) NOT NULL,
  `motbene_descrip` varchar(40) NOT NULL,
  PRIMARY KEY (`idmotivo_beneficio`),
  UNIQUE KEY `motbene_descrip_UNIQUE` (`motbene_descrip`),
  UNIQUE KEY `idmotivo_beneficio_UNIQUE` (`idmotivo_beneficio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `motivo_beneficio`
--

LOCK TABLES `motivo_beneficio` WRITE;
/*!40000 ALTER TABLE `motivo_beneficio` DISABLE KEYS */;
/*!40000 ALTER TABLE `motivo_beneficio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan_estudio`
--

DROP TABLE IF EXISTS `plan_estudio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan_estudio` (
  `idplan_estudio` int(11) NOT NULL,
  `plaestu_descrip` varchar(20) NOT NULL,
  PRIMARY KEY (`idplan_estudio`),
  UNIQUE KEY `plaestu_descrip_UNIQUE` (`plaestu_descrip`),
  UNIQUE KEY `idplan_estudio_UNIQUE` (`idplan_estudio`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan_estudio`
--

LOCK TABLES `plan_estudio` WRITE;
/*!40000 ALTER TABLE `plan_estudio` DISABLE KEYS */;
/*!40000 ALTER TABLE `plan_estudio` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-27 18:10:59
