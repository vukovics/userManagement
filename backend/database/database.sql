SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema userMng
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `userMng` ;
CREATE SCHEMA IF NOT EXISTS `userMng` DEFAULT CHARACTER SET latin1 ;
USE `userMng` ;

-- -----------------------------------------------------
-- Table `userMng`.`groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userMng`.`groups` ;

CREATE TABLE IF NOT EXISTS `userMng`.`groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(45) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 18
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `userMng`.`migrations`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userMng`.`migrations` ;

CREATE TABLE IF NOT EXISTS `userMng`.`migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `userMng`.`password_resets`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userMng`.`password_resets` ;

CREATE TABLE IF NOT EXISTS `userMng`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

CREATE INDEX `password_resets_email_index` ON `userMng`.`password_resets` (`email` ASC);


-- -----------------------------------------------------
-- Table `userMng`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userMng`.`users` ;

CREATE TABLE IF NOT EXISTS `userMng`.`users` (
  `id` INT(10) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(45) NULL DEFAULT NULL,
  `lastname` VARCHAR(45) NULL DEFAULT NULL,
  `email` VARCHAR(255) NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 128
DEFAULT CHARACTER SET = utf8mb4;

CREATE UNIQUE INDEX `users_email_unique` ON `userMng`.`users` (`email` ASC);


-- -----------------------------------------------------
-- Table `userMng`.`user_groups`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `userMng`.`user_groups` ;

CREATE TABLE IF NOT EXISTS `userMng`.`user_groups` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NULL DEFAULT NULL,
  `group_id` INT(11) NULL DEFAULT NULL,
  `created_at` VARCHAR(45) NULL DEFAULT NULL,
  `updated_at` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_gorup_id`
    FOREIGN KEY (`group_id`)
    REFERENCES `userMng`.`groups` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_id`
    FOREIGN KEY (`user_id`)
    REFERENCES `userMng`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 40
DEFAULT CHARACTER SET = latin1;

CREATE INDEX `fk_user_id_idx` ON `userMng`.`user_groups` (`user_id` ASC);

CREATE INDEX `fk_gorup_id_idx` ON `userMng`.`user_groups` (`group_id` ASC);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
