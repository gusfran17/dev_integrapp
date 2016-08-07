SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `ortopedia` ;
CREATE SCHEMA IF NOT EXISTS `ortopedia` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `ortopedia` ;

-- -----------------------------------------------------
-- Table `ortopedia`.`administrador`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`administrador` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`administrador` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(200) NOT NULL ,
  `username` VARCHAR(30) NOT NULL ,
  `password` TEXT NOT NULL ,
  `last_access` DATE NOT NULL ,
  `last_ip` VARCHAR(15) NOT NULL ,
  `forgot_hash` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`ortopedista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`ortopedista` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`ortopedista` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(200) NOT NULL ,
  `username` VARCHAR(30) NOT NULL ,
  `password` TEXT NOT NULL ,
  `last_access` DATE NULL ,
  `last_ip` VARCHAR(15) NULL ,
  `forgot_hash` TEXT NULL ,
  `comercial_address` TEXT NULL ,
  `latLocation` DECIMAL(18,14) NULL ,
  `longLocation` DECIMAL(18,14) NULL ,
  `phone` VARCHAR(60) NULL ,
  `comercial_email` VARCHAR(100) NULL ,
  `locationsure` VARCHAR(45) NULL ,
  `name` VARCHAR(100) NULL ,
  `lastname` VARCHAR(100) NULL ,
  `brand` VARCHAR(45) NULL ,
  `newsletter` VARCHAR(45) NULL ,
  `status` ENUM('active','inactive','pending') NOT NULL DEFAULT 'pending' ,
  `nombre_fantasia` VARCHAR(100) NULL ,
  `razon_social` VARCHAR(50) NULL ,
  `cuit` VARCHAR(100) NULL ,
  `fiscal_address` VARCHAR(100) NULL ,
  `service_description` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`fabricante`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`fabricante` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`fabricante` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(200) NOT NULL ,
  `username` VARCHAR(30) NOT NULL ,
  `password` TEXT NOT NULL ,
  `last_access` DATE NULL ,
  `last_ip` VARCHAR(15) NULL ,
  `forgot_hash` TEXT NULL ,
  `service_description` VARCHAR(200) NULL ,
  `commercial_address` VARCHAR(200) NULL ,
  `phone` VARCHAR(100) NULL ,
  `comercial_email` VARCHAR(100) NULL ,
  `name` VARCHAR(100) NOT NULL ,
  `lastname` VARCHAR(100) NOT NULL ,
  `brand` VARCHAR(45) NULL ,
  `newsletter` VARCHAR(45) NULL ,
  `fiscal_address` VARCHAR(45) NULL ,
  `cbu` VARCHAR(45) NULL ,
  `cuit` VARCHAR(45) NULL ,
  `cheques` VARCHAR(45) NULL ,
  `cuentabancaria` VARCHAR(45) NULL ,
  `status` ENUM('pending', 'active', 'inactive') NOT NULL DEFAULT 'pending' ,
  `register_date` DATETIME NULL ,
  `razon_social` VARCHAR(50) NULL ,
  `nombre_fantasia` VARCHAR(100) NULL ,
  `bank_name` VARCHAR(100) NULL ,
  `bank_sucursal` VARCHAR(50) NULL ,
  `bank_account_number` VARCHAR(100) NULL ,
  `bank_account_name` VARCHAR(100) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`tag` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`tag` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `tag` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`cms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`cms` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`cms` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(45) NOT NULL ,
  `bajada` VARCHAR(200) NOT NULL ,
  `content` TEXT NOT NULL ,
  `creation_date` DATETIME NOT NULL ,
  `valid_since` DATETIME NOT NULL ,
  `valid_thru` DATETIME NOT NULL ,
  `administrador_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_cms_administrador1_idx` (`administrador_id` ASC) ,
  CONSTRAINT `fk_cms_administrador1`
    FOREIGN KEY (`administrador_id` )
    REFERENCES `ortopedia`.`administrador` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`cms_tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`cms_tag` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`cms_tag` (
  `cms_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  INDEX `fk_cms_tag_cms1_idx` (`cms_id` ASC) ,
  INDEX `fk_cms_tag_tag1_idx` (`tag_id` ASC) ,
  CONSTRAINT `fk_cms_tag_cms1`
    FOREIGN KEY (`cms_id` )
    REFERENCES `ortopedia`.`cms` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cms_tag_tag1`
    FOREIGN KEY (`tag_id` )
    REFERENCES `ortopedia`.`tag` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`transferencias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`transferencias` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`transferencias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `amount` DECIMAL(10,2) NOT NULL ,
  `message` TEXT NOT NULL ,
  `transfer_date` DATETIME NOT NULL ,
  `confirmed` TINYINT(1) NOT NULL DEFAULT FALSE ,
  `confirmed_date` DATETIME NULL ,
  `additional_info` TEXT NULL ,
  `administrador_id` INT NULL ,
  `fabricante_id` INT NOT NULL ,
  `imagen_comprobante` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_transferencias_administrador_idx` (`administrador_id` ASC) ,
  INDEX `fk_transferencias_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_transferencias_administrador`
    FOREIGN KEY (`administrador_id` )
    REFERENCES `ortopedia`.`administrador` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_transferencias_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`puja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`puja` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`puja` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `amount` DECIMAL(10,2) NULL ,
  `date_start` DATETIME NULL ,
  `date_end` DATETIME NULL ,
  `categorias_id` INT NULL ,
  `fabricante_id` INT NULL ,
  `bid_hash` VARCHAR(200) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_puja_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_puja_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`categorias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`categorias` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`categorias` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `seo_name` VARCHAR(45) NOT NULL ,
  `parent_id` INT NULL DEFAULT NULL ,
  `ascending_path` TEXT NULL ,
  `order` INT NULL ,
  `puja_id` INT NULL ,
  `costo_publicacion` DECIMAL(10,2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_categorias_categorias1_idx` (`parent_id` ASC) ,
  INDEX `fk_categorias_puja1_idx` (`puja_id` ASC) ,
  CONSTRAINT `fk_categorias_categorias1`
    FOREIGN KEY (`parent_id` )
    REFERENCES `ortopedia`.`categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_categorias_puja1`
    FOREIGN KEY (`puja_id` )
    REFERENCES `ortopedia`.`puja` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`producto`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`producto` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`producto` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `description` TEXT NOT NULL ,
  `short_desc` VARCHAR(200) NOT NULL ,
  `price` DECIMAL(10,2) NOT NULL ,
  `white_paper` TEXT NOT NULL ,
  `code` VARCHAR(45) NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  `categorias_id` INT NOT NULL ,
  `available_stock` INT NOT NULL ,
  `status` ENUM('active', 'inactive', 'published') NOT NULL DEFAULT 'inactive' ,
  `prescription` TEXT NULL ,
  `tax` VARCHAR(45) NULL DEFAULT '21' ,
  `expire_date` DATE NULL ,
  `last_update` DATETIME NOT NULL ,
  `published_date` DATETIME NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_producto_fabricante1_idx` (`fabricante_id` ASC) ,
  INDEX `fk_producto_categorias1_idx` (`categorias_id` ASC) ,
  CONSTRAINT `fk_producto_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_categorias1`
    FOREIGN KEY (`categorias_id` )
    REFERENCES `ortopedia`.`categorias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`pedidos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`pedidos` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `amount` INT NOT NULL ,
  `unit_price` DECIMAL(10,2) NOT NULL ,
  `total_price` DECIMAL(10,2) NOT NULL ,
  `discount_porcent` INT NOT NULL ,
  `discount_value` DECIMAL(10,2) NOT NULL ,
  `producto_id` INT NOT NULL ,
  `ortopedista_id` INT NOT NULL ,
  `date_created` DATETIME NOT NULL ,
  `status` ENUM('aproved', 'rejected', 'sent', 'pending') NULL DEFAULT 'pending' ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_pedidos_producto1_idx` (`producto_id` ASC) ,
  INDEX `fk_pedidos_ortopedista1_idx` (`ortopedista_id` ASC) ,
  CONSTRAINT `fk_pedidos_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedidos_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`ofertas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`ofertas` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`ofertas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NULL ,
  `description` TEXT NULL ,
  `expiration_date` DATE NOT NULL ,
  `producto_id` INT NOT NULL ,
  `image` VARCHAR(100) NOT NULL ,
  `status` ENUM('active','inactive', 'pending') NOT NULL DEFAULT 'pending' ,
  `start_date` DATE NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_ofertas_producto1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_ofertas_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`wall_posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`wall_posts` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`wall_posts` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `content` TEXT NOT NULL ,
  `user_type` VARCHAR(30) NULL ,
  `user_id` INT NULL ,
  `creation_date` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`acceso_listas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`acceso_listas` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`acceso_listas` (
  `ortopedista_id` INT NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  `discount` INT NOT NULL ,
  INDEX `fk_acceso_listas_ortopedista1_idx` (`ortopedista_id` ASC) ,
  INDEX `fk_acceso_listas_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_acceso_listas_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_acceso_listas_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`mensajes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`mensajes` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`mensajes` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `from` VARCHAR(200) NOT NULL ,
  `message` TEXT NULL ,
  `read` TINYINT(1) NULL ,
  `sent_date` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`slideshow`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`slideshow` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`slideshow` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `order` INT NOT NULL ,
  `image` VARCHAR(200) NOT NULL ,
  `slideshow_code` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`imagenes_productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`imagenes_productos` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`imagenes_productos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `filename` VARCHAR(100) NOT NULL ,
  `order` INT NULL ,
  `producto_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_imagenes_productos_producto1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_imagenes_productos_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`provincias`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`provincias` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`provincias` (
  `id` INT NOT NULL ,
  `provincia_name` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`localidades`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`localidades` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`localidades` (
  `id` INT NOT NULL ,
  `localidad_name` VARCHAR(60) NOT NULL ,
  `postal_code` INT(4) NULL ,
  `provincias_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_localidades_provincias1_idx` (`provincias_id` ASC) ,
  CONSTRAINT `fk_localidades_provincias1`
    FOREIGN KEY (`provincias_id` )
    REFERENCES `ortopedia`.`provincias` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`solicitudes_listas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`solicitudes_listas` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`solicitudes_listas` (
  `ortopedista_id` INT NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  `status` ENUM('unread','read','rejected') NOT NULL DEFAULT 'unread' ,
  `reject_reason` VARCHAR(100) NULL ,
  INDEX `fk_solicitudes_listas_ortopedista1_idx` (`ortopedista_id` ASC) ,
  INDEX `fk_solicitudes_listas_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_solicitudes_listas_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_solicitudes_listas_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`transacciones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`transacciones` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`transacciones` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date_added` DATETIME NOT NULL ,
  `description` VARCHAR(100) NOT NULL ,
  `debit` DECIMAL(10,2) NOT NULL ,
  `credit` DECIMAL(10,2) NOT NULL ,
  `total` DECIMAL(10,2) NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_transacciones_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_transacciones_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`notas_pedidos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`notas_pedidos` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`notas_pedidos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nota` TEXT NOT NULL ,
  `date_added` DATETIME NOT NULL ,
  `pedidos_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notas_pedidos_pedidos1_idx` (`pedidos_id` ASC) ,
  CONSTRAINT `fk_notas_pedidos_pedidos1`
    FOREIGN KEY (`pedidos_id` )
    REFERENCES `ortopedia`.`pedidos` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`historico_puja`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`historico_puja` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`historico_puja` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `amount` DECIMAL(10,2) NOT NULL ,
  `date_puja` DATETIME NOT NULL ,
  `bid_hash` VARCHAR(150) NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_historico_puja_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_historico_puja_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`menus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`menus` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`menus` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NOT NULL ,
  `seo_name` VARCHAR(45) NOT NULL ,
  `parent_id` INT NULL DEFAULT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_categorias_categorias1_idx` (`parent_id` ASC) ,
  CONSTRAINT `fk_categorias_categorias10`
    FOREIGN KEY (`parent_id` )
    REFERENCES `ortopedia`.`menus` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`catalogo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`catalogo` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`catalogo` (
  `producto_id` INT NOT NULL ,
  `ortopedista_id` INT NOT NULL ,
  INDEX `fk_catalogo_producto1_idx` (`producto_id` ASC) ,
  INDEX `fk_catalogo_ortopedista1_idx` (`ortopedista_id` ASC) ,
  CONSTRAINT `fk_catalogo_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_catalogo_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`notas_productos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`notas_productos` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`notas_productos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `nota` TEXT NOT NULL ,
  `date_added` DATETIME NOT NULL ,
  `producto_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_notas_pedidos_copy1_producto1_idx` (`producto_id` ASC) ,
  CONSTRAINT `fk_notas_pedidos_copy1_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`phones`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`phones` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`phones` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `phone` VARCHAR(100) NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phones_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_phones_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`carrito`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`carrito` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`carrito` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `amount` INT NULL ,
  `producto_id` INT NOT NULL ,
  `ortopedista_id` INT NOT NULL ,
  `fabricante_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_carrito_producto1_idx` (`producto_id` ASC) ,
  INDEX `fk_carrito_ortopedista1_idx` (`ortopedista_id` ASC) ,
  INDEX `fk_carrito_fabricante1_idx` (`fabricante_id` ASC) ,
  CONSTRAINT `fk_carrito_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrito_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrito_fabricante1`
    FOREIGN KEY (`fabricante_id` )
    REFERENCES `ortopedia`.`fabricante` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`alertas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`alertas` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`alertas` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `message` VARCHAR(100) NULL ,
  `status` ENUM('unread', 'read') NULL DEFAULT 'unread' ,
  `level` INT NULL ,
  `time` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`propaganda`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`propaganda` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`propaganda` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(100) NULL ,
  `description` TEXT NULL ,
  `image` VARCHAR(100) NOT NULL ,
  `start_date` DATE NOT NULL ,
  `expiration_date` DATE NOT NULL ,
  `status` ENUM('active','inactive', 'pending') NOT NULL DEFAULT 'pending' ,
  `producto_id` INT NOT NULL ,
  `ortopedista_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_propaganda_producto1_idx` (`producto_id` ASC) ,
  INDEX `fk_propaganda_ortopedista1_idx` (`ortopedista_id` ASC) ,
  CONSTRAINT `fk_propaganda_producto1`
    FOREIGN KEY (`producto_id` )
    REFERENCES `ortopedia`.`producto` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_propaganda_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`ci_sessions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`ci_sessions` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`ci_sessions` (
  `session_id` VARCHAR(40) NOT NULL DEFAULT 0 ,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT 0 ,
  `user_agent` VARCHAR(120) NOT NULL ,
  `last_activity` INT(10) UNSIGNED NOT NULL DEFAULT 0 ,
  `user_data` TEXT NOT NULL ,
  PRIMARY KEY (`session_id`) ,
  INDEX `last_activity` (`last_activity` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `ortopedia`.`phones_ortopedista`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `ortopedia`.`phones_ortopedista` ;

CREATE  TABLE IF NOT EXISTS `ortopedia`.`phones_ortopedista` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `phone` VARCHAR(100) NOT NULL ,
  `ortopedista_id` INT NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_phones_ortopedista_ortopedista1_idx` (`ortopedista_id` ASC) ,
  CONSTRAINT `fk_phones_ortopedista_ortopedista1`
    FOREIGN KEY (`ortopedista_id` )
    REFERENCES `ortopedia`.`ortopedista` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `ortopedia` ;

-- -----------------------------------------------------
-- Placeholder table for view `ortopedia`.`catalogo_ortopedista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ortopedia`.`catalogo_ortopedista` (`producto_id` INT, `name` INT, `code` INT, `price` INT, `fabricante_id` INT, `short_desc` INT, `available_stock` INT, `ortopedista_id` INT);

-- -----------------------------------------------------
-- Placeholder table for view `ortopedia`.`view1`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ortopedia`.`view1` (`id` INT);

-- -----------------------------------------------------
-- View `ortopedia`.`catalogo_ortopedista`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `ortopedia`.`catalogo_ortopedista` ;
DROP TABLE IF EXISTS `ortopedia`.`catalogo_ortopedista`;
USE `ortopedia`;
CREATE  OR REPLACE VIEW `ortopedia`.`catalogo_ortopedista` AS SELECT
    `producto`.`id` AS `producto_id`
    , `producto`.`name`
    , `producto`.`code`
    , `producto`.`price`
    , `producto`.`fabricante_id`
    , `producto`.`short_desc`
    , `producto`.`available_stock`
    , `acceso_listas`.`ortopedista_id`
FROM
    `ortopedia`.`producto`
    INNER JOIN `ortopedia`.`fabricante` 
        ON (`producto`.`fabricante_id` = `fabricante`.`id`)
    INNER JOIN `ortopedia`.`acceso_listas` 
        ON (`acceso_listas`.`fabricante_id` = `fabricante`.`id`)
    INNER JOIN `ortopedia`.`ortopedista` 
        ON (`acceso_listas`.`ortopedista_id` = `ortopedista`.`id`);

-- -----------------------------------------------------
-- View `ortopedia`.`view1`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `ortopedia`.`view1` ;
DROP TABLE IF EXISTS `ortopedia`.`view1`;
USE `ortopedia`;
;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`administrador`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`administrador` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`) VALUES (1, 'dacalvi@gmail.com', 'dacalvi', 'Bofu0gRgJXbOj7S4wNSQrIDdGiUDSzyoglBlepj6b7kjskAM/fNvZSKqHWK/TfyRdbSYSqpbpNtSurRU9Pkpvg==', '2013-12-12', '127.0.0.1', NULL);
INSERT INTO `ortopedia`.`administrador` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`) VALUES (2, 'ortopediafernandez@gmail.com', 'patricio', 'Bofu0gRgJXbOj7S4wNSQrIDdGiUDSzyoglBlepj6b7kjskAM/fNvZSKqHWK/TfyRdbSYSqpbpNtSurRU9Pkpvg==', '2013-12-12', '127.0.0.1', NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`ortopedista`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`ortopedista` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`, `comercial_address`, `latLocation`, `longLocation`, `phone`, `comercial_email`, `locationsure`, `name`, `lastname`, `brand`, `newsletter`, `status`, `nombre_fantasia`, `razon_social`, `cuit`, `fiscal_address`, `service_description`) VALUES (1, 'ortopedia@gmail.com', 'ortopedia', 'Bofu0gRgJXbOj7S4wNSQrIDdGiUDSzyoglBlepj6b7kjskAM/fNvZSKqHWK/TfyRdbSYSqpbpNtSurRU9Pkpvg==', '2013-12-12', '127.0.0.1', NULL, 'test', 1, 1, '555-555', 'alguien@microsoft.com', NULL, 'Daniel', 'Calvi', 'ortopedia one', NULL, 'active', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ortopedia`.`ortopedista` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`, `comercial_address`, `latLocation`, `longLocation`, `phone`, `comercial_email`, `locationsure`, `name`, `lastname`, `brand`, `newsletter`, `status`, `nombre_fantasia`, `razon_social`, `cuit`, `fiscal_address`, `service_description`) VALUES (2, 'ortopediaalguien@gmail.com', 'ortopediaapocrifa', 'Bofu0gRgJXbOj7S4wNSQrIDdGiUDSzyoglBlepj6b7kjskAM/fNvZSKqHWK/TfyRdbSYSqpbpNtSurRU9Pkpvg==', '2013-12-12', '127.0.0.1', NULL, 'test', 1, 1, '555', 'alguien@gmail.com', NULL, 'NoSe', 'Dunno', 'second one', NULL, 'active', NULL, NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`fabricante`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`fabricante` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`, `service_description`, `commercial_address`, `phone`, `comercial_email`, `name`, `lastname`, `brand`, `newsletter`, `fiscal_address`, `cbu`, `cuit`, `cheques`, `cuentabancaria`, `status`, `register_date`, `razon_social`, `nombre_fantasia`, `bank_name`, `bank_sucursal`, `bank_account_number`, `bank_account_name`) VALUES (1, 'dacalvi+fabricante@gmail.com', 'danifabrica', 'g/5tFDXdORxzzxqCmZgKWkzlaXiFVx5edx+bUsBNuncOaEmXmQ9enRCiRra7BtqElRHbdFAXDr6C2awPgP6knw==', '2013-12-12', '127.0.0.1', NULL, 'descripcion del servicio', 'direccion comercial', '555 - 555', 'alguien@microsoft.com', 'daniel', 'calvi', 'kreativ', NULL, 'dire fiscal', '112233', NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `ortopedia`.`fabricante` (`id`, `email`, `username`, `password`, `last_access`, `last_ip`, `forgot_hash`, `service_description`, `commercial_address`, `phone`, `comercial_email`, `name`, `lastname`, `brand`, `newsletter`, `fiscal_address`, `cbu`, `cuit`, `cheques`, `cuentabancaria`, `status`, `register_date`, `razon_social`, `nombre_fantasia`, `bank_name`, `bank_sucursal`, `bank_account_number`, `bank_account_name`) VALUES (2, 'dacalvi+fabricante2@gmail.com', 'danifabrica2', 'g/5tFDXdORxzzxqCmZgKWkzlaXiFVx5edx+bUsBNuncOaEmXmQ9enRCiRra7BtqElRHbdFAXDr6C2awPgP6knw==', '2013-12-12', '127.0.0.1', NULL, 'descripcion del servicio', 'direccion comercial', '555 - 555', 'alguien@microsoft.com', 'daniel', 'calvi', 'kreativ2', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`tag`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`tag` (`id`, `tag`) VALUES (1, 'capacitaciones');

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`cms`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`cms` (`id`, `title`, `bajada`, `content`, `creation_date`, `valid_since`, `valid_thru`, `administrador_id`) VALUES (1, 'Luxación Acromioclavicular', 'bajada', 'contenido', '2013-12-12', '2014-01-01', '2014-12-12', 1);
INSERT INTO `ortopedia`.`cms` (`id`, `title`, `bajada`, `content`, `creation_date`, `valid_since`, `valid_thru`, `administrador_id`) VALUES (2, 'Pie torcido', 'bajada', 'contenido', '2013-12-12', '2014-01-01', '2014-12-12', 1);
INSERT INTO `ortopedia`.`cms` (`id`, `title`, `bajada`, `content`, `creation_date`, `valid_since`, `valid_thru`, `administrador_id`) VALUES (3, 'Test title', 'bajada', 'contenido', '2013-12-12', '2014-01-01', '2014-12-12', 1);
INSERT INTO `ortopedia`.`cms` (`id`, `title`, `bajada`, `content`, `creation_date`, `valid_since`, `valid_thru`, `administrador_id`) VALUES (4, 'test title', 'bajada', 'contenido', '2013-12-12', '2014-01-01', '2014-12-12', 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`cms_tag`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`cms_tag` (`cms_id`, `tag_id`) VALUES (1, 1);
INSERT INTO `ortopedia`.`cms_tag` (`cms_id`, `tag_id`) VALUES (2, 1);
INSERT INTO `ortopedia`.`cms_tag` (`cms_id`, `tag_id`) VALUES (3, 1);
INSERT INTO `ortopedia`.`cms_tag` (`cms_id`, `tag_id`) VALUES (4, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`categorias`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (1, 'Sillas de ruedas', 'sillas-de-ruedas', null, NULL, 1, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (2, 'Bipedestadores', 'bipedestadores', null, NULL, 2, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (3, 'Dormitorio', 'dormitorio', null, NULL, 3, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (4, 'Baño', 'bano', null, NULL, 4, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (5, 'Ayudas Movilidad', 'movilidad', null, NULL, 5, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (6, 'Vida diaria', 'vida-diaria', null, NULL, 6, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (7, 'Incontinencia', 'incontinencia', null, NULL, 7, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (8, 'Rehabilitación', 'rehabilitacion', null, NULL, 8, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (9, 'Amputados', 'amputados', null, NULL, 9, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (10, 'Manuales', 'manuales', 1, NULL, 10, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (11, 'Motorizadas', 'motorizadas', 1, NULL, 11, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (12, 'Pediatricas', 'pediatricas', 1, NULL, 12, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (13, 'Accesorios', 'accesorios', 1, NULL, 13, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (14, 'Mecánicos', 'mecanicos', 2, NULL, 14, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (15, 'Eléctricos', 'electricos', 2, NULL, 15, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (16, 'Camas', 'camas', 3, NULL, 16, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (17, 'Elevadores', 'elevadores', 3, NULL, 17, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (18, 'Colchones', 'colchones', 3, NULL, 18, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (19, 'Sillas higiénicas', 'sillas-higienicas', 4, NULL, 19, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (20, 'Elevadores de inodoro', 'elevadores-de-inodoro', 4, NULL, 20, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (21, 'Barras de seguridad', 'barras-de-seguridad', 4, NULL, 21, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (22, 'Ducha y bañera', 'ducha-banera', 4, NULL, 22, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (23, 'Griferia', 'griferia', 4, NULL, 23, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (24, 'Antideslizantes', 'antideslizantes', 4, NULL, 24, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (25, 'Bastones', 'bastones', 5, NULL, 25, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (26, 'Muletas', 'muletas', 5, NULL, 26, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (27, 'Andadores', 'andadores', 5, NULL, 27, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (28, 'Colocador de medias', 'colocadores-de-medias', 6, NULL, 28, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (29, 'Abotonadores', 'abotonadores', 6, NULL, 29, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (30, 'Calzadores', 'calzadores', 6, NULL, 30, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (31, 'Platos cubiertos y vasos', 'platos-cubiertos-vasos', 6, NULL, 31, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (32, 'Alcanzaobjetos', 'alcanzaobjetos', 6, NULL, 32, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (33, 'Engrosadores', 'engrosadores', 6, NULL, 33, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (34, 'Cubre colchon', 'cubre-colchon', 7, NULL, 34, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (35, 'Bombachas', 'bombachas', 7, NULL, 35, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (36, 'Pañales', 'panales', 7, NULL, 36, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (37, 'Elasticos', 'elasticos', 8, NULL, 37, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (38, 'Equilibrio', 'equilibrio', 8, NULL, 38, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (39, 'Pesas y mancuernas', 'pesas-mancuernas', 8, NULL, 39, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (40, 'Manuales', 'manuales', 16, NULL, 40, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (41, 'Eléctricas', 'electricas', 16, NULL, 41, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (43, 'Rehabilitacion y Ejercicios', 'rehabilitacion-y-ejercicios', null, NULL, 42, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (44, 'Poslipoaspiración', 'polipoaspiracion', null, NULL, 43, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (45, 'Post Mastectomia', 'post-mastectomia', null, NULL, 44, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (47, 'Presoterapia/Quemados', 'presoterapia-quemados', null, NULL, 45, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (48, 'Materiales para taller', 'materiales-para-taller', null, NULL, 46, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (49, 'Maquinas y Herramientas', 'maquinas-y-herramientas', null, NULL, 47, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (50, 'Antiescaras', 'antiescaras', null, NULL, 48, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (51, 'Theratog', 'theratog', null, NULL, 49, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (52, 'Taping', 'taping', null, NULL, 50, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (53, 'Calzado', 'calzado', null, NULL, 51, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (54, 'Traslado', 'traslado', 10, NULL, 52, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (55, 'Posturales', 'posturales', 10, NULL, 53, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (56, 'Autopropulsion', 'autopropulsion', 10, NULL, 54, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (57, 'Posturales', 'posturales', 10, NULL, 55, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (58, 'Aluminio', 'aluminio', 54, NULL, 56, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (59, 'Acero', 'acero', 54, NULL, 57, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (60, 'Rigidas', 'rigidas', 56, NULL, 58, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (61, 'Pleado tijera', 'pleado tijera', 56, NULL, 59, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (62, 'Sillas ', 'sillas ', 11, NULL, 60, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (63, 'Scooters', 'scooters', 11, NULL, 61, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (64, 'Autopropulsion', 'autopropulsion', 12, NULL, 62, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (65, 'Traslado', 'traslado', 12, NULL, 63, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (66, 'Posturales', 'posturales', 12, NULL, 64, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (67, 'Triciclos', 'triciclos', 12, NULL, 65, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (68, 'Ruedas', 'ruedas', 13, NULL, 66, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (69, 'Respaldos', 'respaldos', 13, NULL, 67, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (70, 'Almohadones', 'almohadones', 13, NULL, 68, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (71, 'Sujeción', 'sujeción', 13, NULL, 69, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (72, 'Apoya cabezas', 'apoya-cabezas', 13, NULL, 70, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (73, 'Aluminio', 'aluminio', 64, NULL, 71, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (74, 'Acero', 'acero', 64, NULL, 72, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (75, 'Aluminio', 'aluminio', 65, NULL, 73, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (76, 'Acero', 'acero', 65, NULL, 74, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (77, 'Madera', 'madera', 25, NULL, 75, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (78, 'Metalicos', 'metalicos', 25, NULL, 76, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (79, 'Adultos', 'adultos', 26, NULL, 77, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (80, 'Pediatricos', 'pediatricos', 26, NULL, 78, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (81, 'Muletas', 'muletas', 5, NULL, 79, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (82, 'Madera', 'metalicos', 81, NULL, 80, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (83, 'Metalicos', 'metalicos', 81, NULL, 80, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (84, 'Con ruedas', 'con-ruedas', 79, NULL, 82, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (85, 'Sin ruedas', 'sin-ruedas', 79, NULL, 83, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (86, 'Con ruedas', 'con-ruedas', 80, NULL, 84, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (87, 'Sin ruedas', 'sin-ruedas', 80, NULL, 85, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (88, 'Para manos', 'para-manos', 8, NULL, 86, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (89, 'Prótesis', 'protesis', null, NULL, 87, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (90, 'Miembro superior', 'miembro-superior', 89, NULL, 88, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (91, 'Miembro inferior', 'miembro-inferior', 89, NULL, 89, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (92, 'Mamarias', 'mamarias', 89, NULL, 90, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (93, 'Otros', 'otros', 89, NULL, 91, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (94, 'Mecánicas', 'mecanicas', 90, NULL, 92, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (95, 'Electricas', 'electricas', 90, NULL, 93, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (96, 'Cosmeticas', 'cosmeticas', 90, NULL, 94, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (97, 'Pies', 'pies', 91, NULL, 95, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (98, 'Tobillos', 'tobillos', 91, NULL, 96, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (99, 'Rodillas', 'rodillas', 91, NULL, 97, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (100, 'Caderas', 'caderas', 91, NULL, 98, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (101, 'Modulos', 'modulos', 91, NULL, 99, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (102, 'Valvulas', 'valvulas', 91, NULL, 100, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (103, 'Liners', 'liners', 91, NULL, 101, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (104, 'Productos para agua', 'productos-para-agua', 91, NULL, 102, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (105, 'Bolsa de colocación', 'bolsa-de-colocacion', 91, NULL, 103, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (106, 'Adaptadores', 'adaptadores', 91, NULL, 104, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (107, 'Componentes', 'componentes', 91, NULL, 105, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (108, 'Fundas cosmeticas', 'fundas-cosmeticas', 91, NULL, 106, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (109, 'Medias cosmeticas', 'medias-cosmeticas', 91, NULL, 107, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (110, 'Tubos', 'tubos', 91, NULL, 108, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (111, 'Socket lock', 'socket lock', 91, NULL, 109, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (112, 'Manos', 'manos', 94, NULL, 110, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (113, 'Muñecas', 'munecas', 94, NULL, 111, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (114, 'Codos', 'codos', 94, NULL, 112, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (115, 'Hombros', 'hombros', 94, NULL, 113, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (116, 'Manos', 'manos', 95, NULL, 114, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (117, 'Muñecas', 'munecas', 95, NULL, 115, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (118, 'Codos', 'codos', 95, NULL, 116, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (119, 'Neoprenne/gel/tela', 'neoprenne-gel-tela', null, NULL, 117, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (120, 'Miembro superior', 'miembro-superior', 119, NULL, 118, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (121, 'Miembro inferior', 'miembro-inferior', 119, NULL, 119, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (122, 'Cuello / Tronco', 'cuello-tronco', 119, NULL, 120, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (123, 'Vendas', 'vendas', 119, NULL, 121, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (124, 'Planchas y Laminas de gel', 'planchas-laminas-gel', 119, NULL, 122, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (125, 'Apositos multiuso', 'apositos-multiuso', 119, NULL, 123, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (126, 'Muñeca', 'muñeca', 120, NULL, 124, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (127, 'Mano', 'mano', 120, NULL, 125, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (128, 'Codo', 'codo ', 120, NULL, 126, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (129, 'Brazo', 'brazo', 120, NULL, 127, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (130, 'Pie / Tobillo', 'pie-tobillo', 121, NULL, 128, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (131, 'Gemelera', 'gemelera', 121, NULL, 129, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (132, 'Rodilla', 'rodilla', 121, NULL, 130, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (133, 'Muslo', 'muslo', 121, NULL, 131, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (134, 'Calzas', 'calzas', 121, NULL, 132, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (135, 'Cuello', 'cuello', 122, NULL, 133, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (136, 'Hombros', 'hombros', 122, NULL, 134, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (137, 'Correctores posturales', 'correctores-posturales', 122, NULL, 135, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (138, 'Fajas toraxicas', 'fajas-toraxicas', 122, NULL, 136, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (139, 'Fajas abdominales', 'fajas-abdominales', 122, NULL, 137, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (140, 'Fajas maternales', 'fajas-maternales', 122, NULL, 138, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (141, 'Fajas sacro lumbares', 'fajas-sacro-lumbares', 122, NULL, 139, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (142, 'Fajas industriales', 'fajas-industriales', 122, NULL, 140, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (143, 'Vendas', 'vendas', 119, NULL, 141, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (144, 'Planchas y laminas de gel', 'planchas-laminas-gel', 119, NULL, 142, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (145, 'Apositos multiuso', 'apositos-multiuso', 119, NULL, 143, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (147, 'Post mastectomias', 'post-mastectomias', null, NULL, 144, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (148, 'Protesis', 'protesis', NULL, NULL, 145, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (149, 'Corpiños ', 'corpinos ', 148, NULL, 146, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (150, 'Trajes de baño', 'trajes-de-bano', 148, NULL, 147, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (151, 'Mangas para linfedema', 'mangas-para-linfedema', 148, NULL, 148, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (152, 'Indumentaria', 'indumentaria', 148, NULL, 149, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (153, 'Medias', 'medias', null, NULL, 150, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (154, 'Compresión / Descanso', 'compresion-descanso', 153, NULL, 151, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (155, 'Deportivas', 'deportivas', 153, NULL, 152, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (156, 'Medias diabeticos', 'medias-diabeticos', 153, NULL, 153, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (157, 'Mujer', 'mujer', 154, NULL, 154, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (158, 'Hombre', 'hombre', 154, NULL, 155, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (159, '3/4', '3-4', 157, NULL, 156, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (160, 'Muslo', 'muslo', 157, NULL, 157, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (161, 'Panty', 'panty', 157, NULL, 158, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (162, '3/4', '3-4', 158, NULL, 159, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (163, 'Muslo', 'muslo', 158, NULL, 160, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (164, 'Baja compresión', 'baja-compresion', 159, NULL, 161, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (165, 'Media compresión', 'media-compresion', 159, NULL, 162, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (166, 'Fuerte compresión', 'fuerte-compresion', 159, NULL, 163, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (167, 'Baja compresión', 'baja-compresion', 160, NULL, 164, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (168, 'Media compresión', 'media-compresion', 160, NULL, 165, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (169, 'Fuerte compresión', 'fuerte-compresion', 160, NULL, 166, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (170, 'Baja compresión', 'baja-compresion', 161, NULL, 167, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (171, 'Media compresión', 'media-compresion', 161, NULL, 168, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (172, 'Fuerte compresión', 'fuerte-compresion', 161, NULL, 169, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (173, 'Baja compresión', 'baja-compresion', 162, NULL, 170, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (174, 'Media compresión', 'media-compresion', 162, NULL, 171, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (175, 'Fuerte compresión', 'fuerte-compresion', 162, NULL, 172, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (176, 'Baja compresión', 'baja-compresion', 163, NULL, 173, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (177, 'Media compresión', 'media-compresion', 163, NULL, 174, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (178, 'Fuerte compresión', 'fuerte-compresion', 163, NULL, 175, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (179, 'Presoterapia / Quemados', 'preosterapia-quemados', null, NULL, 176, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (180, 'Calzas', 'calzas', 179, NULL, 177, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (181, 'Corset', 'corset', 179, NULL, 178, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (182, 'Mentonera', 'mentonera', 179, NULL, 179, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (183, 'Sosten', 'sosten', 179, NULL, 180, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (184, 'Trusa', 'trusa', 179, NULL, 181, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (185, 'Materiales taller', 'materiales-taller', null, NULL, 182, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (186, 'plasticos', 'plasticos', 185, NULL, 183, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (187, 'goma eva', 'goma eva', 185, NULL, 184, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (188, 'Resinas / Catalizadores', 'resinas-catalizadores', 185, NULL, 185, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (189, 'carbono', 'carbono', 185, NULL, 186, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (190, 'pegamentos', 'pegamentos', 185, NULL, 187, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (191, 'solventes', 'solventes', 185, NULL, 188, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (192, 'latex', 'latex', 185, NULL, 189, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (193, 'goma espumas', 'goma espumas', 185, NULL, 190, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (194, 'Arcos / Olivas / Barras', 'arcos-olivas-barras', 185, NULL, 191, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (195, 'Cuñas', 'cuñas', 185, NULL, 192, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (196, 'Taloneras', 'taloneras', 185, NULL, 193, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (197, 'Maquinas y Herramientas', 'maquinas-herramientas', null, NULL, 194, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (198, 'hornos', 'hornos', 197, NULL, 195, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (199, 'cortantes', 'cortantes', 197, NULL, 196, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (200, 'perforantes', 'perforantes', 197, NULL, 197, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (201, 'de desgaste', 'de desgaste', 197, NULL, 198, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (202, 'roters', 'roters', 197, NULL, 199, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (203, 'bomba de vacio', 'bomba de vacio', 197, NULL, 180, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (204, 'presion', 'presion', 197, NULL, 181, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (205, 'de ajuste', 'de ajuste', 197, NULL, 182, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (206, 'Antiescaras', 'antiescaras', null, NULL, 183, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (207, 'Colchones', 'colchones', 206, NULL, 184, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (208, 'Pieles ovinas', 'pieles-ovinas', 206, NULL, 185, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (209, 'Taloneras', 'taloneras', 206, NULL, 186, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (210, 'Almohadones', 'almohadones', 206, NULL, 187, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (214, 'Niños', 'ninos', 53, NULL, 188, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (215, 'Mujeres', 'mujeres', 53, NULL, 189, NULL, NULL);
INSERT INTO `ortopedia`.`categorias` (`id`, `name`, `seo_name`, `parent_id`, `ascending_path`, `order`, `puja_id`, `costo_publicacion`) VALUES (216, 'Hombres', 'hombres', 53, NULL, 190, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`wall_posts`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`wall_posts` (`id`, `content`, `user_type`, `user_id`, `creation_date`) VALUES (1, 'test', 'fabricante', 1, '2014-01-01 00:00:00');

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`acceso_listas`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`acceso_listas` (`ortopedista_id`, `fabricante_id`, `discount`) VALUES (1, 1, 10);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`provincias`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (1, ' Buenos Aires');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (2, ' Capital Federal');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (3, ' Catamarca');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (4, ' Chaco');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (5, ' Chubut');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (6, ' Córdoba');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (7, ' Corrientes');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (8, ' Entre Ríos');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (9, ' Formosa');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (10, ' Jujuy');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (11, ' La Pampa');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (12, ' La Rioja');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (13, ' Mendoza');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (14, ' Misiones');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (15, ' Neuquén');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (16, ' Río Negro');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (17, ' Salta');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (18, ' San Juan');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (19, ' San Luis');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (20, ' Santa Cruz');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (21, ' Santa Fé');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (22, ' Santiago del Estero');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (23, ' Tierra del Fuego');
INSERT INTO `ortopedia`.`provincias` (`id`, `provincia_name`) VALUES (24, ' Tucumán');

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`transacciones`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`transacciones` (`id`, `date_added`, `description`, `debit`, `credit`, `total`, `fabricante_id`) VALUES (1, '2013-12-12 12:00:03', 'transaccion de ejemplo', 10, 0, 10, 1);
INSERT INTO `ortopedia`.`transacciones` (`id`, `date_added`, `description`, `debit`, `credit`, `total`, `fabricante_id`) VALUES (2, '2013-12-12 12:00:02', 'transaccion de ejemplo', 0, 15, 20, 1);
INSERT INTO `ortopedia`.`transacciones` (`id`, `date_added`, `description`, `debit`, `credit`, `total`, `fabricante_id`) VALUES (3, '2013-12-12 12:00:01', 'transaccion de ejemplo', 0, 5, 5, 1);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`menus`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (1, 'Sillas de ruedas', 'sillas-de-ruedas', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (2, 'Bipedestadores', 'bipedestadores', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (3, 'Dormitorio', 'dormitorio', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (4, 'Baño', 'bano', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (5, 'Ayudas Movilidad', 'movilidad', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (6, 'Vida diaria', 'vida-diaria', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (7, 'Incontinencia', 'incontinencia', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (8, 'Rehabilitación', 'rehabilitacion', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (9, 'Amputados', 'amputados', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (10, 'Manuales', 'manuales', 1);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (11, 'Motorizadas', 'motorizadas', 1);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (12, 'Pediatricas', 'pediatricas', 1);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (13, 'Accesorios', 'accesorios', 1);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (14, 'Mecánicos', 'mecanicos', 2);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (15, 'Eléctricos', 'electricos', 2);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (16, 'Camas', 'camas', 3);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (17, 'Elevadores', 'elevadores', 3);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (18, 'Colchones', 'colchones', 3);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (19, 'Sillas higiénicas', 'sillas-higienicas', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (20, 'Elevadores de inodoro', 'elevadores-de-inodoro', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (21, 'Barras de seguridad', 'barras-de-seguridad', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (22, 'Ducha y bañera', 'ducha-banera', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (23, 'Griferia', 'griferia', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (24, 'Antideslizantes', 'antideslizantes', 4);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (25, 'Bastones', 'bastones', 5);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (26, 'Muletas', 'muletas', 5);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (27, 'Andadores', 'andadores', 5);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (28, 'Colocador de medias', 'colocadores-de-medias', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (29, 'Abotonadores', 'abotonadores', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (30, 'Calzadores', 'calzadores', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (31, 'Platos cubiertos y vasos', 'platos-cubiertos-vasos', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (32, 'Alcanzaobjetos', 'alcanzaobjetos', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (33, 'Engrosadores', 'engrosadores', 6);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (34, 'Cubre colchon', 'cubre-colchon', 7);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (35, 'Bombachas', 'bombachas', 7);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (36, 'Pañales', 'panales', 7);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (37, 'Elasticos', 'elasticos', 8);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (38, 'Equilibrio', 'equilibrio', 8);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (39, 'Pesas y mancuernas', 'pesas-mancuernas', 8);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (40, 'Manuales', 'manuales', 16);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (41, 'Eléctricas', 'electricas', 16);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (42, 'Neoprenne/gel/tela', 'neoprenne-gel-tela', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (43, 'Rehabilitacion y Ejercicios', 'rehabilitacion-y-ejercicios', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (44, 'Poslipoaspiración', 'polipoaspiracion', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (45, 'Post Mastectomia', 'post-mastectomia', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (46, 'Medias', 'medias', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (47, 'Presoterapia/Quemados', 'presoterapia-quemados', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (48, 'Materiales para taller', 'materiales-para-taller', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (49, 'Maquinas y Herramientas', 'maquinas-y-herramientas', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (50, 'Antiescaras', 'antiescaras', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (51, 'Theratog', 'theratog', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (52, 'Taping', 'taping', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (53, 'Calzado', 'calzado', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (54, 'Traslado', 'traslado', 10);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (55, 'Posturales', 'posturales', 10);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (56, 'Autopropulsion', 'autopropulsion', 10);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (57, 'Posturales', 'posturales', 10);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (58, 'Aluminio', 'aluminio', 54);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (59, 'Acero', 'acero', 54);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (60, 'Rigidas', 'rigidas', 56);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (61, 'Pleado tijera', 'pleado tijera', 56);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (62, 'Sillas ', 'sillas ', 11);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (63, 'Scooters', 'scooters', 11);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (64, 'Autopropulsion', 'autopropulsion', 12);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (65, 'Traslado', 'traslado', 12);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (66, 'Posturales', 'posturales', 12);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (67, 'Triciclos', 'triciclos', 12);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (68, 'Ruedas', 'ruedas', 13);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (69, 'Respaldos', 'respaldos', 13);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (70, 'Almohadones', 'almohadones', 13);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (71, 'Sujeción', 'sujeción', 13);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (72, 'Apoya cabezas', 'apoya-cabezas', 13);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (73, 'Aluminio', 'aluminio', 64);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (74, 'Acero', 'acero', 64);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (75, 'Aluminio', 'aluminio', 65);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (76, 'Acero', 'acero', 65);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (77, 'Madera', 'madera', 25);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (78, 'Metalicos', 'metalicos', 25);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (79, 'Adultos', 'adultos', 26);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (80, 'Pediatricos', 'pediatricos', 26);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (81, 'Muletas', 'muletas', 5);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (82, 'Madera', 'metalicos', 81);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (83, 'Metalicos', 'metalicos', 81);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (84, 'Con ruedas', 'con-ruedas', 79);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (85, 'Sin ruedas', 'sin-ruedas', 79);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (86, 'Con ruedas', 'con-ruedas', 80);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (87, 'Sin ruedas', 'sin-ruedas', 80);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (88, 'Para manos', 'para-manos', 8);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (89, 'Prótesis', 'protesis', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (90, 'Miembro superior', 'miembro-superior', 89);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (91, 'Miembro inferior', 'miembro-inferior', 89);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (92, 'Mamarias', 'mamarias', 89);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (93, 'Otros', 'otros', 89);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (94, 'Mecánicas', 'mecanicas', 90);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (95, 'Electricas', 'electricas', 90);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (96, 'Cosmeticas', 'cosmeticas', 90);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (97, 'Pies', 'pies', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (98, 'Tobillos', 'tobillos', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (99, 'Rodillas', 'rodillas', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (100, 'Caderas', 'caderas', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (101, 'Modulos', 'modulos', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (102, 'Valvulas', 'valvulas', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (103, 'Liners', 'liners', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (104, 'Productos para agua', 'productos-para-agua', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (105, 'Bolsa de colocación', 'bolsa-de-colocacion', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (106, 'Adaptadores', 'adaptadores', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (107, 'Componentes', 'componentes', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (108, 'Fundas cosmeticas', 'fundas-cosmeticas', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (109, 'Medias cosmeticas', 'medias-cosmeticas', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (110, 'Tubos', 'tubos', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (111, 'Socket lock', 'socket lock', 91);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (112, 'Manos', 'manos', 94);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (113, 'Muñecas', 'munecas', 94);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (114, 'Codos', 'codos', 94);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (115, 'Hombros', 'hombros', 94);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (116, 'Manos', 'manos', 95);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (117, 'Muñecas', 'munecas', 95);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (118, 'Codos', 'codos', 95);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (119, 'Neoprenne/gel/tela', 'neoprenne-gel-tela', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (120, 'Miembro superior', 'miembro-superior', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (121, 'Miembro inferior', 'miembro-inferior', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (122, 'Cuello / Tronco', 'cuello-tronco', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (123, 'Vendas', 'vendas', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (124, 'Planchas y Laminas de gel', 'planchas-laminas-gel', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (125, 'Apositos multiuso', 'apositos-multiuso', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (126, 'Muñeca', 'muñeca', 120);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (127, 'Mano', 'mano', 120);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (128, 'Codo', 'codo ', 120);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (129, 'Brazo', 'brazo', 120);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (130, 'Pie / Tobillo', 'pie-tobillo', 121);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (131, 'Gemelera', 'gemelera', 121);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (132, 'Rodilla', 'rodilla', 121);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (133, 'Muslo', 'muslo', 121);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (134, 'Calzas', 'calzas', 121);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (135, 'Cuello', 'cuello', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (136, 'Hombros', 'hombros', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (137, 'Correctores posturales', 'correctores-posturales', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (138, 'Fajas toraxicas', 'fajas-toraxicas', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (139, 'Fajas abdominales', 'fajas-abdominales', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (140, 'Fajas maternales', 'fajas-maternales', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (141, 'Fajas sacro lumbares', 'fajas-sacro-lumbares', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (142, 'Fajas industriales', 'fajas-industriales', 122);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (143, 'Vendas', 'vendas', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (144, 'Planchas y laminas de gel', 'planchas-laminas-gel', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (145, 'Apositos multiuso', 'apositos-multiuso', 119);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (146, 'Poslipoaspiración', 'poslipoaspiracion', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (147, 'Post mastectomias', 'post-mastectomias', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (148, 'Protesis', 'protesis', 148);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (149, 'Corpiños ', 'corpinos ', 148);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (150, 'Trajes de baño', 'trajes-de-bano', 148);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (151, 'Mangas para linfedema', 'mangas-para-linfedema', 148);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (152, 'Indumentaria', 'indumentaria', 148);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (153, 'Medias', 'medias', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (154, 'Compresión / Descanso', 'compresion-descanso', 153);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (155, 'Deportivas', 'deportivas', 153);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (156, 'Medias diabeticos', 'medias-diabeticos', 153);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (157, 'Mujer', 'mujer', 154);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (158, 'Hombre', 'hombre', 154);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (159, '3/4', '3-4', 157);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (160, 'Muslo', 'muslo', 157);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (161, 'Panty', 'panty', 157);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (162, '3/4', '3-4', 158);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (163, 'Muslo', 'muslo', 158);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (164, 'Baja compresión', 'baja-compresion', 159);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (165, 'Media compresión', 'media-compresion', 159);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (166, 'Fuerte compresión', 'fuerte-compresion', 159);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (167, 'Baja compresión', 'baja-compresion', 160);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (168, 'Media compresión', 'media-compresion', 160);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (169, 'Fuerte compresión', 'fuerte-compresion', 160);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (170, 'Baja compresión', 'baja-compresion', 161);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (171, 'Media compresión', 'media-compresion', 161);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (172, 'Fuerte compresión', 'fuerte-compresion', 161);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (173, 'Baja compresión', 'baja-compresion', 162);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (174, 'Media compresión', 'media-compresion', 162);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (175, 'Fuerte compresión', 'fuerte-compresion', 162);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (176, 'Baja compresión', 'baja-compresion', 163);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (177, 'Media compresión', 'media-compresion', 163);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (178, 'Fuerte compresión', 'fuerte-compresion', 163);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (179, 'Presoterapia / Quemados', 'preosterapia-quemados', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (180, 'Calzas', 'calzas', 179);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (181, 'Corset', 'corset', 179);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (182, 'Mentonera', 'mentonera', 179);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (183, 'Sosten', 'sosten', 179);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (184, 'Trusa', 'trusa', 179);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (185, 'Materiales taller', 'materiales-taller', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (186, 'plasticos', 'plasticos', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (187, 'goma eva', 'goma eva', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (188, 'Resinas / Catalizadores', 'resinas-catalizadores', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (189, 'carbono', 'carbono', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (190, 'pegamentos', 'pegamentos', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (191, 'solventes', 'solventes', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (192, 'latex', 'latex', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (193, 'goma espumas', 'goma espumas', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (194, 'Arcos / Olivas / Barras', 'arcos-olivas-barras', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (195, 'Cuñas', 'cuñas', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (196, 'Taloneras', 'taloneras', 185);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (197, 'Maquinas y Herramientas', 'maquinas-herramientas', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (198, 'hornos', 'hornos', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (199, 'cortantes', 'cortantes', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (200, 'perforantes', 'perforantes', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (201, 'de desgaste', 'de desgaste', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (202, 'roters', 'roters', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (203, 'bomba de vacio', 'bomba de vacio', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (204, 'presion', 'presion', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (205, 'de ajuste', 'de ajuste', 197);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (206, 'Antiescaras', 'antiescaras', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (207, 'Colchones', 'colchones', 206);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (208, 'Pieles ovinas', 'pieles-ovinas', 206);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (209, 'Taloneras', 'taloneras', 206);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (210, 'Almohadones', 'almohadones', 206);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (211, 'Tratogs', 'tratogs', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (212, 'Taping', 'taping', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (213, 'Calzado', 'calzado', null);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (214, 'Niños', 'ninos', 213);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (215, 'Mujeres', 'mujeres', 213);
INSERT INTO `ortopedia`.`menus` (`id`, `name`, `seo_name`, `parent_id`) VALUES (216, 'Hombres', 'hombres', 213);

COMMIT;

-- -----------------------------------------------------
-- Data for table `ortopedia`.`alertas`
-- -----------------------------------------------------
START TRANSACTION;
USE `ortopedia`;
INSERT INTO `ortopedia`.`alertas` (`id`, `message`, `status`, `level`, `time`) VALUES (1, 'Alerta de ejemplo', 'unread', 1, NULL);
INSERT INTO `ortopedia`.`alertas` (`id`, `message`, `status`, `level`, `time`) VALUES (2, 'Alerta de ejemplo leida', 'read', 1, NULL);

COMMIT;
