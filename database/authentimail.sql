-- MySQL Script generated by MySQL Workbench
-- 06/09/15 10:56:00
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema authentimail
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema authentimail
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `authentimail` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `authentimail` ;

-- -----------------------------------------------------
-- Table `authentimail`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `authentimail`.`users` ;

CREATE TABLE IF NOT EXISTS `authentimail`.`users` (
  `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `alt_email` VARCHAR(255) NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `authentimail`.`authentications`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `authentimail`.`authentications` ;

CREATE TABLE IF NOT EXISTS `authentimail`.`authentications` (
  `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(255) NOT NULL,
  `user_ID` INT(11) UNSIGNED NOT NULL,
  `expiration_date` DATETIME NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_authentications_users_idx` (`user_ID` ASC),
  UNIQUE INDEX `token_UNIQUE` (`token` ASC),
  CONSTRAINT `fk_authentications_users`
    FOREIGN KEY (`user_ID`)
    REFERENCES `authentimail`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `authentimail`.`registrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `authentimail`.`registrations` ;

CREATE TABLE IF NOT EXISTS `authentimail`.`registrations` (
  `ID` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` VARCHAR(255) NOT NULL,
  `user_ID` INT(11) UNSIGNED NULL,
  `expiration_date` INT(11) UNSIGNED NOT NULL,
  `type` TINYINT(1) UNSIGNED NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_registrations_users1_idx` (`user_ID` ASC),
  UNIQUE INDEX `token_UNIQUE` (`token` ASC),
  CONSTRAINT `fk_registrations_users1`
    FOREIGN KEY (`user_ID`)
    REFERENCES `authentimail`.`users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `users` (`ID`,`username`,`email`) VALUES (1,'derp','derp@localhost');