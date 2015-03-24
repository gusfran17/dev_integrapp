-- MySQL dump 10.13  Distrib 5.5.38, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ortopedia
-- ------------------------------------------------------
-- Server version	5.5.38-0+wheezy1

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
-- Table structure for table `acceso_listas`
--

DROP TABLE IF EXISTS `acceso_listas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acceso_listas` (
  `ortopedista_id` int(11) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  `discount` int(11) NOT NULL,
  KEY `fk_acceso_listas_ortopedista1_idx` (`ortopedista_id`),
  KEY `fk_acceso_listas_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_acceso_listas_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_acceso_listas_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `last_access` date NOT NULL,
  `last_ip` varchar(15) NOT NULL,
  `forgot_hash` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alertas`
--

DROP TABLE IF EXISTS `alertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(100) DEFAULT NULL,
  `status` enum('unread','read') DEFAULT 'unread',
  `level` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `carrito`
--

DROP TABLE IF EXISTS `carrito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carrito` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  `ortopedista_id` int(11) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_carrito_producto1_idx` (`producto_id`),
  KEY `fk_carrito_ortopedista1_idx` (`ortopedista_id`),
  KEY `fk_carrito_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_carrito_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrito_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrito_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `catalogo`
--

DROP TABLE IF EXISTS `catalogo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `catalogo` (
  `producto_id` int(11) NOT NULL,
  `ortopedista_id` int(11) NOT NULL,
  KEY `fk_catalogo_producto1_idx` (`producto_id`),
  KEY `fk_catalogo_ortopedista1_idx` (`ortopedista_id`),
  CONSTRAINT `fk_catalogo_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalogo_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `catalogo_ortopedista`
--

DROP TABLE IF EXISTS `catalogo_ortopedista`;
/*!50001 DROP VIEW IF EXISTS `catalogo_ortopedista`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `catalogo_ortopedista` (
  `producto_id` tinyint NOT NULL,
  `name` tinyint NOT NULL,
  `code` tinyint NOT NULL,
  `price` tinyint NOT NULL,
  `fabricante_id` tinyint NOT NULL,
  `short_desc` tinyint NOT NULL,
  `available_stock` tinyint NOT NULL,
  `ortopedista_id` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `seo_name` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `ascending_path` text,
  `order` int(11) DEFAULT NULL,
  `puja_id` int(11) DEFAULT NULL,
  `costo_publicacion` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorias_categorias1_idx` (`parent_id`),
  KEY `fk_categorias_puja1_idx` (`puja_id`),
  CONSTRAINT `fk_categorias_categorias1` FOREIGN KEY (`parent_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_puja1` FOREIGN KEY (`puja_id`) REFERENCES `puja` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=226 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ciudad`
--

DROP TABLE IF EXISTS `ciudad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ciudad` (
  `id` int(4) NOT NULL,
  `ciudad_nombre` varchar(60) NOT NULL,
  `cp` int(4) NOT NULL,
  `provincia_id` smallint(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cp` (`cp`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cms`
--

DROP TABLE IF EXISTS `cms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `bajada` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `creation_date` datetime NOT NULL,
  `valid_since` datetime NOT NULL,
  `valid_thru` datetime NOT NULL,
  `administrador_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_cms_administrador1_idx` (`administrador_id`),
  CONSTRAINT `fk_cms_administrador1` FOREIGN KEY (`administrador_id`) REFERENCES `administrador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cms_tag`
--

DROP TABLE IF EXISTS `cms_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_tag` (
  `cms_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  KEY `fk_cms_tag_cms1_idx` (`cms_id`),
  KEY `fk_cms_tag_tag1_idx` (`tag_id`),
  CONSTRAINT `fk_cms_tag_cms1` FOREIGN KEY (`cms_id`) REFERENCES `cms` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cms_tag_tag1` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fabricante`
--

DROP TABLE IF EXISTS `fabricante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fabricante` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `last_access` date DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `forgot_hash` text,
  `service_description` varchar(200) DEFAULT NULL,
  `commercial_address` varchar(200) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `comercial_email` varchar(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `brand` varchar(45) DEFAULT NULL,
  `newsletter` varchar(45) DEFAULT NULL,
  `fiscal_address` varchar(45) DEFAULT NULL,
  `cbu` varchar(45) DEFAULT NULL,
  `cuit` varchar(45) DEFAULT NULL,
  `cheques` varchar(45) DEFAULT NULL,
  `cuentabancaria` varchar(45) DEFAULT NULL,
  `status` enum('pending','active','inactive') NOT NULL DEFAULT 'pending',
  `register_date` datetime DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `nombre_fantasia` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_sucursal` varchar(50) DEFAULT NULL,
  `bank_account_number` varchar(100) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historico_puja`
--

DROP TABLE IF EXISTS `historico_puja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historico_puja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `date_puja` datetime NOT NULL,
  `bid_hash` varchar(150) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_historico_puja_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_historico_puja_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `imagenes_productos`
--

DROP TABLE IF EXISTS `imagenes_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imagenes_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `order` int(11) DEFAULT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_imagenes_productos_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_imagenes_productos_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `localidades`
--

DROP TABLE IF EXISTS `localidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `localidades` (
  `id` int(11) NOT NULL,
  `localidad_name` varchar(60) NOT NULL,
  `postal_code` int(4) DEFAULT NULL,
  `provincias_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_localidades_provincias1_idx` (`provincias_id`),
  CONSTRAINT `fk_localidades_provincias1` FOREIGN KEY (`provincias_id`) REFERENCES `provincias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(200) NOT NULL,
  `message` text,
  `read` tinyint(1) DEFAULT NULL,
  `sent_date` datetime DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `seo_name` varchar(45) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorias_categorias1_idx` (`parent_id`),
  CONSTRAINT `fk_categorias_categorias10` FOREIGN KEY (`parent_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notas_pedidos`
--

DROP TABLE IF EXISTS `notas_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notas_pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota` text NOT NULL,
  `date_added` datetime NOT NULL,
  `pedidos_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notas_pedidos_pedidos1_idx` (`pedidos_id`),
  CONSTRAINT `fk_notas_pedidos_pedidos1` FOREIGN KEY (`pedidos_id`) REFERENCES `pedidos` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `notas_productos`
--

DROP TABLE IF EXISTS `notas_productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notas_productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nota` text NOT NULL,
  `date_added` datetime NOT NULL,
  `producto_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_notas_pedidos_copy1_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_notas_pedidos_copy1_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `expiration_date` date NOT NULL,
  `producto_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `start_date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_ofertas_producto1_idx` (`producto_id`),
  CONSTRAINT `fk_ofertas_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ortopedista`
--

DROP TABLE IF EXISTS `ortopedista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ortopedista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `last_access` date DEFAULT NULL,
  `last_ip` varchar(15) DEFAULT NULL,
  `forgot_hash` text,
  `comercial_address` text,
  `latLocation` decimal(18,14) DEFAULT NULL,
  `longLocation` decimal(18,14) DEFAULT NULL,
  `phone` varchar(60) DEFAULT NULL,
  `comercial_email` varchar(100) DEFAULT NULL,
  `locationsure` varchar(45) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `brand` varchar(45) DEFAULT NULL,
  `newsletter` varchar(45) DEFAULT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `nombre_fantasia` varchar(100) DEFAULT NULL,
  `razon_social` varchar(50) DEFAULT NULL,
  `cuit` varchar(100) DEFAULT NULL,
  `fiscal_address` varchar(100) DEFAULT NULL,
  `service_description` text,
  `city` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(11) NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `discount_porcent` int(11) NOT NULL,
  `discount_value` decimal(10,2) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `ortopedista_id` int(11) NOT NULL,
  `date_created` datetime NOT NULL,
  `status` enum('aproved','rejected','sent','pending') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  KEY `fk_pedidos_producto1_idx` (`producto_id`),
  KEY `fk_pedidos_ortopedista1_idx` (`ortopedista_id`),
  CONSTRAINT `fk_pedidos_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phones`
--

DROP TABLE IF EXISTS `phones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(100) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phones_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_phones_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `phones_ortopedista`
--

DROP TABLE IF EXISTS `phones_ortopedista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phones_ortopedista` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(100) NOT NULL,
  `ortopedista_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_phones_ortopedista_ortopedista1_idx` (`ortopedista_id`),
  CONSTRAINT `fk_phones_ortopedista_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `producto`
--

DROP TABLE IF EXISTS `producto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `producto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `short_desc` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `white_paper` text NOT NULL,
  `code` varchar(45) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  `categorias_id` int(11) NOT NULL,
  `available_stock` int(11) NOT NULL,
  `status` enum('active','inactive','published') NOT NULL DEFAULT 'inactive',
  `prescription` text,
  `tax` varchar(45) DEFAULT '21',
  `expire_date` date DEFAULT NULL,
  `last_update` datetime NOT NULL,
  `published_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_producto_fabricante1_idx` (`fabricante_id`),
  KEY `fk_producto_categorias1_idx` (`categorias_id`),
  CONSTRAINT `fk_producto_categorias1` FOREIGN KEY (`categorias_id`) REFERENCES `categorias` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `propaganda`
--

DROP TABLE IF EXISTS `propaganda`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `propaganda` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` text,
  `image` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `expiration_date` date NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `producto_id` int(11) NOT NULL,
  `ortopedista_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_propaganda_producto1_idx` (`producto_id`),
  KEY `fk_propaganda_ortopedista1_idx` (`ortopedista_id`),
  CONSTRAINT `fk_propaganda_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_propaganda_producto1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `provincias`
--

DROP TABLE IF EXISTS `provincias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provincias` (
  `id` int(11) NOT NULL,
  `provincia_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `puja`
--

DROP TABLE IF EXISTS `puja`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `puja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) DEFAULT NULL,
  `date_start` datetime DEFAULT NULL,
  `date_end` datetime DEFAULT NULL,
  `categorias_id` int(11) DEFAULT NULL,
  `fabricante_id` int(11) DEFAULT NULL,
  `bid_hash` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_puja_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_puja_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `slideshow`
--

DROP TABLE IF EXISTS `slideshow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order` int(11) NOT NULL,
  `image` varchar(200) NOT NULL,
  `slideshow_code` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `solicitudes_listas`
--

DROP TABLE IF EXISTS `solicitudes_listas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `solicitudes_listas` (
  `ortopedista_id` int(11) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  `status` enum('unread','read','rejected') NOT NULL DEFAULT 'unread',
  `reject_reason` varchar(100) DEFAULT NULL,
  KEY `fk_solicitudes_listas_ortopedista1_idx` (`ortopedista_id`),
  KEY `fk_solicitudes_listas_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_solicitudes_listas_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitudes_listas_ortopedista1` FOREIGN KEY (`ortopedista_id`) REFERENCES `ortopedista` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transacciones`
--

DROP TABLE IF EXISTS `transacciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transacciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_added` datetime NOT NULL,
  `description` varchar(100) NOT NULL,
  `debit` decimal(10,2) NOT NULL,
  `credit` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `fabricante_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transacciones_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_transacciones_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `transferencias`
--

DROP TABLE IF EXISTS `transferencias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transferencias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `amount` decimal(10,2) NOT NULL,
  `message` text NOT NULL,
  `transfer_date` datetime NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `confirmed_date` datetime DEFAULT NULL,
  `additional_info` text,
  `administrador_id` int(11) DEFAULT NULL,
  `fabricante_id` int(11) NOT NULL,
  `imagen_comprobante` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_transferencias_administrador_idx` (`administrador_id`),
  KEY `fk_transferencias_fabricante1_idx` (`fabricante_id`),
  CONSTRAINT `fk_transferencias_administrador` FOREIGN KEY (`administrador_id`) REFERENCES `administrador` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencias_fabricante1` FOREIGN KEY (`fabricante_id`) REFERENCES `fabricante` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wall_posts`
--

DROP TABLE IF EXISTS `wall_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wall_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `user_type` varchar(30) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `creation_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `catalogo_ortopedista`
--

/*!50001 DROP TABLE IF EXISTS `catalogo_ortopedista`*/;
/*!50001 DROP VIEW IF EXISTS `catalogo_ortopedista`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `catalogo_ortopedista` AS select `producto`.`id` AS `producto_id`,`producto`.`name` AS `name`,`producto`.`code` AS `code`,`producto`.`price` AS `price`,`producto`.`fabricante_id` AS `fabricante_id`,`producto`.`short_desc` AS `short_desc`,`producto`.`available_stock` AS `available_stock`,`acceso_listas`.`ortopedista_id` AS `ortopedista_id` from (((`producto` join `fabricante` on((`producto`.`fabricante_id` = `fabricante`.`id`))) join `acceso_listas` on((`acceso_listas`.`fabricante_id` = `fabricante`.`id`))) join `ortopedista` on((`acceso_listas`.`ortopedista_id` = `ortopedista`.`id`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-19 15:28:14
