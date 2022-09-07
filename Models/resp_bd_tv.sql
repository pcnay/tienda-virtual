-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: bd_tienda_virtual
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0+deb10u1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `t_Categorias`
--

DROP TABLE IF EXISTS `t_Categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Categorias` (
  `id_categoria` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `portada` varchar(100) NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_categoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Categorias`
--

LOCK TABLES `t_Categorias` WRITE;
/*!40000 ALTER TABLE `t_Categorias` DISABLE KEYS */;
INSERT INTO `t_Categorias` VALUES (1,'Nombre Categoria 1','Descripcion Categoria 1','portada_categoria.jpg','2022-08-22 21:41:08',0),(3,'Nombre Categoria 3','Descripcion Categoria 3','portada_categoria.jpg','2022-08-22 22:03:07',0),(4,'Nombre Categotoria 5','Descripcion Categoria 5','img_ae9853263e6a5a38c20de499762fcb92.jpg','2022-08-22 22:24:11',0),(5,'Nombre Categotoria 6 Edit','Descripcion Categoria 6 Edit','img_c2bb51c7b3f13980262cb0a6fdccc282.jpg','2022-08-29 21:37:29',1),(6,'Nombre Categoria 2','Descripcion Categoria 2','img_7d5206c6f52b7c330bbd42e0c55d7cf4.jpg','2022-08-30 21:22:21',1),(7,'Nombre Categoria 4','Descripcion Categoria 4','img_69fada933808ba4c2f2987ce0a1800c0.jpg','2022-08-30 21:23:17',1);
/*!40000 ALTER TABLE `t_Categorias` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Detalle_Pedidos`
--

DROP TABLE IF EXISTS `t_Detalle_Pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Detalle_Pedidos` (
  `id_detalle_pedido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pedidoid` int(10) unsigned NOT NULL,
  `productoid` int(10) unsigned NOT NULL,
  `cantidad` smallint(5) unsigned DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_pedido`),
  KEY `pedidoid` (`pedidoid`),
  KEY `productoid` (`productoid`),
  CONSTRAINT `t_Detalle_Pedidos_ibfk_1` FOREIGN KEY (`pedidoid`) REFERENCES `t_Pedidos` (`id_pedido`) ON UPDATE CASCADE,
  CONSTRAINT `t_Detalle_Pedidos_ibfk_2` FOREIGN KEY (`productoid`) REFERENCES `t_Productos` (`id_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Detalle_Pedidos`
--

LOCK TABLES `t_Detalle_Pedidos` WRITE;
/*!40000 ALTER TABLE `t_Detalle_Pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Detalle_Pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Detalle_Temp`
--

DROP TABLE IF EXISTS `t_Detalle_Temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Detalle_Temp` (
  `id_detalle_pedido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `productoid` int(10) unsigned NOT NULL,
  `cantidad` smallint(5) unsigned DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_detalle_pedido`),
  KEY `productoid` (`productoid`),
  CONSTRAINT `t_Detalle_Temp_ibfk_1` FOREIGN KEY (`productoid`) REFERENCES `t_Productos` (`id_producto`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Detalle_Temp`
--

LOCK TABLES `t_Detalle_Temp` WRITE;
/*!40000 ALTER TABLE `t_Detalle_Temp` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Detalle_Temp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Modulos`
--

DROP TABLE IF EXISTS `t_Modulos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Modulos` (
  `id_modulo` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_modulo`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Modulos`
--

LOCK TABLES `t_Modulos` WRITE;
/*!40000 ALTER TABLE `t_Modulos` DISABLE KEYS */;
INSERT INTO `t_Modulos` VALUES (1,'Dashboard','Descripcion Dashboard',1),(2,'Usuarios','Descripcion Usuarios',1),(3,'Clientes','Descripcion Clientes',1),(4,'Productos','Descripcion Tienda',1),(5,'Pedidos','Descripcion Productos',1),(6,'Categorias','Descripcion Categorias',1);
/*!40000 ALTER TABLE `t_Modulos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Pedidos`
--

DROP TABLE IF EXISTS `t_Pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Pedidos` (
  `id_pedido` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `personaid` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `monto` decimal(10,2) DEFAULT NULL,
  `tipopagoid` smallint(5) unsigned DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_pedido`),
  KEY `personaid` (`personaid`),
  CONSTRAINT `t_Pedidos_ibfk_1` FOREIGN KEY (`personaid`) REFERENCES `t_Personas` (`id_persona`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Pedidos`
--

LOCK TABLES `t_Pedidos` WRITE;
/*!40000 ALTER TABLE `t_Pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Permisos`
--

DROP TABLE IF EXISTS `t_Permisos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Permisos` (
  `id_permiso` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `rolid` smallint(5) unsigned NOT NULL,
  `moduloid` smallint(5) unsigned NOT NULL,
  `r` tinyint(4) DEFAULT 0,
  `w` tinyint(4) DEFAULT 0,
  `u` tinyint(4) DEFAULT 0,
  `d` tinyint(4) DEFAULT 0,
  PRIMARY KEY (`id_permiso`),
  KEY `rolid` (`rolid`),
  KEY `moduloid` (`moduloid`),
  CONSTRAINT `t_Permisos_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `t_Rol` (`id_rol`) ON UPDATE CASCADE,
  CONSTRAINT `t_Permisos_ibfk_2` FOREIGN KEY (`moduloid`) REFERENCES `t_Modulos` (`id_modulo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=632 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Permisos`
--

LOCK TABLES `t_Permisos` WRITE;
/*!40000 ALTER TABLE `t_Permisos` DISABLE KEYS */;
INSERT INTO `t_Permisos` VALUES (608,3,1,1,0,0,0),(609,3,2,1,1,1,1),(610,3,3,1,1,1,0),(611,3,4,1,1,1,0),(612,3,5,0,0,0,0),(613,3,6,1,1,1,0),(614,2,1,0,0,0,0),(615,2,2,0,0,0,0),(616,2,3,0,0,0,0),(617,2,4,1,1,1,1),(618,2,5,0,0,0,0),(619,2,6,0,0,0,0),(626,1,1,1,0,0,0),(627,1,2,1,1,1,1),(628,1,3,1,1,1,1),(629,1,4,1,1,0,0),(630,1,5,0,0,0,0),(631,1,6,1,1,1,1);
/*!40000 ALTER TABLE `t_Permisos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Personas`
--

DROP TABLE IF EXISTS `t_Personas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Personas` (
  `id_persona` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `identificacion` varchar(30) DEFAULT NULL,
  `nombres` varchar(80) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `email_user` varchar(100) DEFAULT NULL,
  `passwords` varchar(75) DEFAULT NULL,
  `nit` varchar(20) DEFAULT NULL,
  `nombrefiscal` varchar(80) DEFAULT NULL,
  `direccionfiscal` varchar(100) DEFAULT NULL,
  `toke` varchar(80) DEFAULT NULL,
  `rolid` smallint(5) unsigned NOT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_persona`),
  KEY `rolid` (`rolid`),
  CONSTRAINT `t_Personas_ibfk_1` FOREIGN KEY (`rolid`) REFERENCES `t_Rol` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Personas`
--

LOCK TABLES `t_Personas` WRITE;
/*!40000 ALTER TABLE `t_Personas` DISABLE KEYS */;
INSERT INTO `t_Personas` VALUES (1,'Super Usuario','Super Usuario','Super Usuarios',NULL,'super-usuario@correo.com','2bfb187788962c6e32ab22c47f42ba191fd85a0b6bbd92fd61c61be72c8e57ac',NULL,NULL,NULL,NULL,1,'2022-06-24 21:46:34',1),(2,'ABCDEF','NombreAdministradors','ApellidoAdministrador','999999999','administrador@correo.com','8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414',NULL,NULL,NULL,NULL,1,'2022-06-28 21:33:04',1),(3,'ABCDSEDEditado','SupervisorNombreEditado','SupervisorApellido','9999999999','supervisor@correo.com','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',NULL,NULL,NULL,NULL,2,'2022-06-28 22:09:55',1),(4,'AVFDDF0123456','NombreSupervisors','ApellidoSupervisors','999999999000','supervisor1212@correo.com','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',NULL,NULL,NULL,NULL,3,'2022-06-29 21:26:56',1),(5,'OPOP039403Editar','AdministradorEditar','AdministradorDosEditar','999999999','pcnay2003@gmail.com','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92','12345678900000','Nombre Fiscal Editado','Direccion Fiscal Editado',NULL,1,'2022-07-05 21:08:47',1),(6,'09923','Conserge','ApellidoConserge','12345689','conserge@correo.com','8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92',NULL,NULL,NULL,NULL,3,'2022-07-20 22:02:09',1),(7,'identifcliente','Aa','Asdadsa','89898989','asdasdas@asda.com','a2d8e4373a2ad0bbb8e216bacaa9b54294fa5cb6047a2f3841754481a8a79dd2','sldada','asdjla','asda',NULL,4,'2022-08-01 19:20:03',0),(8,'IdentificacionCliente','NombreClienteEditado','ApellidosCliente','5687852356','clienteeditado@correo.com','968cb6a970be3dda27d41b687d126ed4d286881b347b8dd0945fbae45cb6f5ee','IndentTribCliente','NombreFiscalCliente','DireccFiscalCliente',NULL,4,'2022-08-01 19:22:37',0),(9,'IdentCliente2EditadoEditado','NombreClienteDosEditado','ApellidoClienteDosEditado','98656569999','correocliente2editado@correo.com','03da752911f180ed6cf650b8268431845f3104a7721f2ad8605bc5965a284f05','IdentifTribEdi','NombreFiscalClienteDosEditado','DireccionFiscalClienteDosEditado',NULL,4,'2022-08-01 22:22:17',0),(10,'IdentifClienteDos','NombreClienteDos','ApellidosClienteDos','6598656545','clientedos@corre.com','ee29eb4a8725678278ac439cf7abfd2a849cdc7378a6b6316017b81c51d720e7','IdentifTribDosE','NombreFiscalDosEditado','DireccionFiscalDosEd',NULL,4,'2022-08-09 21:09:15',1),(11,'IdentifClienteTres','NombreClienteTress','ApellidoClienteTress','659845154','clientetress@correo.com','8b128f5d7967bc796433e2a4f06ef8de0a17bb896e1facf932a89a89ff7d0df7','IdentifTribTres','NombreFiscalTress','DireccFiscalTress',NULL,4,'2022-08-09 22:01:20',1),(12,'identfjTres','NombreTres','ApellidoTres','69856463','correotres@correo.com','eb045d78d273107348b0300c01d29b7552d622abbc6faf81b3ec55359aa9950c','identTribTres','NombreFiscalTress','DireccFiscalTres',NULL,4,'2022-08-10 21:48:03',1),(13,'IdentfCuatro','NombreCuatro','ApellidoCuatro','6649658956','correocuatro@correo.com','eb045d78d273107348b0300c01d29b7552d622abbc6faf81b3ec55359aa9950c','IdentifTributCua667','NombreFiscalCuatro','DireccionFiscalCuatro',NULL,4,'2022-08-12 21:58:38',1);
/*!40000 ALTER TABLE `t_Personas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Productos`
--

DROP TABLE IF EXISTS `t_Productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Productos` (
  `id_producto` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `categoriaid` smallint(5) unsigned NOT NULL,
  `codigo` varchar(30) DEFAULT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `stock` smallint(5) unsigned DEFAULT NULL,
  `imagen` varchar(100) DEFAULT NULL,
  `datecreated` datetime NOT NULL DEFAULT current_timestamp(),
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_producto`),
  KEY `categoriaid` (`categoriaid`),
  CONSTRAINT `t_Productos_ibfk_1` FOREIGN KEY (`categoriaid`) REFERENCES `t_Categorias` (`id_categoria`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Productos`
--

LOCK TABLES `t_Productos` WRITE;
/*!40000 ALTER TABLE `t_Productos` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Rol`
--

DROP TABLE IF EXISTS `t_Rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Rol` (
  `id_rol` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `nombrerol` varchar(50) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `estatus` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Rol`
--

LOCK TABLES `t_Rol` WRITE;
/*!40000 ALTER TABLE `t_Rol` DISABLE KEYS */;
INSERT INTO `t_Rol` VALUES (1,'Administrador','Descripcion Administrador',1),(2,'Supervisor','Descripcion Supervisor',1),(3,'Guardia Entrada','Descripcion Guarda Entrada',1),(4,'Clientes','Descripcion Clientes',1);
/*!40000 ALTER TABLE `t_Rol` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-09-05 19:27:11
