-- MySQL Script generated by MySQL Workbench
-- Sat 28 Jan 2017 08:58:29 PM CST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`users` (
  `username` VARCHAR(64) NOT NULL,
  `password` VARCHAR(64) NOT NULL COMMENT 'super secure plaintext password (this isn’t a security class!)',
  `email` VARCHAR(64) NOT NULL,
  `last_name` VARCHAR(64) NOT NULL,
  `first_name` VARCHAR(64) NOT NULL,
  `current_cart` TEXT NULL DEFAULT NULL,
  PRIMARY KEY (`username`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`products`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`products` (
  `product_id` VARCHAR(64) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `description` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`product_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sales`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sales` (
  `sale_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(64) NOT NULL COMMENT 'Who bought it?',
  `date` TIMESTAMP NULL DEFAULT NULL COMMENT 'When did they buy it?',
  `amount` DECIMAL(10,2) NOT NULL COMMENT 'How much was it?',
  PRIMARY KEY (`sale_id`),
  INDEX `sales_users_idx` (`username` ASC),
  CONSTRAINT `sales_users`
    FOREIGN KEY (`username`)
    REFERENCES `mydb`.`users` (`username`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`sale_items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`sale_items` (
  `sale_item_id` BIGINT(20) NOT NULL AUTO_INCREMENT,
  `sale_id` BIGINT(20) NOT NULL COMMENT 'Which sale is this part of?',
  `product_id` VARCHAR(64) NOT NULL COMMENT 'What item was sold?',
  `quantity` BIGINT(20) NOT NULL COMMENT 'How many of them?',
  `price` DECIMAL(10,2) NOT NULL COMMENT 'At what price?',
  PRIMARY KEY (`sale_item_id`),
  INDEX `sale_items_products_idx` (`product_id` ASC),
  INDEX `sale_items_sales_idx` (`sale_id` ASC),
  CONSTRAINT `sale_items_products`
    FOREIGN KEY (`product_id`)
    REFERENCES `mydb`.`products` (`product_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT,
  CONSTRAINT `sale_items_sales`
    FOREIGN KEY (`sale_id`)
    REFERENCES `mydb`.`sales` (`sale_id`)
    ON DELETE RESTRICT
    ON UPDATE RESTRICT)
ENGINE = InnoDB;

CREATE USER 'web_user' IDENTIFIED BY 'web_user';

GRANT SELECT, INSERT, TRIGGER, UPDATE ON TABLE `mydb`.* TO 'web_user';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `mydb`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`users` (`username`, `password`, `email`, `last_name`, `first_name`, `current_cart`) VALUES ('test', 'password', 'test@example.com', 'User', 'Test', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `mydb`.`products`
-- -----------------------------------------------------
START TRANSACTION;
USE `mydb`;
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('WIN10', 'Windows 10: Home Edition', 119.99, 'Spyware included for free.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('NEWELL-001', 'Teapot', 19.75, 'Made in Utah.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('PC-128000', '4GB DDR4 PC-12800 RAM', 24.99, 'Digital download link provided.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('MUG-001', 'Tea Mug', 9.99, 'Tea not included.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('TEA-001', '20 ct. Tea Bags', 4.99, 'Standard issue tea.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('TEA-002', '20 ct. Medium-Octane Tea Bags', 6.99, 'High caffenne content for those early mornings.');
INSERT INTO `mydb`.`products` (`product_id`, `name`, `price`, `description`) VALUES ('TEA-003', '20 ct. High-Octane Tea Bags', 19.99, 'Authentic Irish tea. Whiskey included.');

COMMIT;

