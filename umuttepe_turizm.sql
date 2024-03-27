-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema umuttepe_turizm
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `umuttepe_turizm` ;

-- -----------------------------------------------------
-- Schema umuttepe_turizm
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `umuttepe_turizm` DEFAULT CHARACTER SET utf8 ;
USE `umuttepe_turizm` ;

-- -----------------------------------------------------
-- Table `umuttepe_turizm`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `umuttepe_turizm`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `kimlik_no` VARCHAR(11) NOT NULL,
  `ad` VARCHAR(50) NOT NULL,
  `soyadi` VARCHAR(50) NOT NULL,
  `telefon_no` VARCHAR(10) NOT NULL,
  `e_posta` VARCHAR(255) NOT NULL,
  `sifre` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `kimlik_no_UNIQUE` (`kimlik_no` ASC) VISIBLE,
  UNIQUE INDEX `eposta_UNIQUE` (`e_posta` ASC) VISIBLE,
  UNIQUE INDEX `telefon_no_UNIQUE` (`telefon_no` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `umuttepe_turizm`.`sefer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `umuttepe_turizm`.`sefer` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `kalkis` VARCHAR(8) NOT NULL,
  `varis` VARCHAR(8) NOT NULL,
  `tarih` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `umuttepe_turizm`.`bilet`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `umuttepe_turizm`.`bilet` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `userId` INT NOT NULL,
  `seferId` INT NOT NULL,
  `koltuk_no` TINYINT NOT NULL,
  `alim_tarihi` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ad` VARCHAR(50) NOT NULL,
  `soyadi` VARCHAR(50) NOT NULL,
  `cinsiyet` ENUM('E', 'K') NOT NULL,
  `pnr` VARCHAR(28) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `userId_idx` (`userId` ASC) VISIBLE,
  INDEX `seferId_idx` (`seferId` ASC) VISIBLE,
  CONSTRAINT `userId`
    FOREIGN KEY (`userId`)
    REFERENCES `umuttepe_turizm`.`users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `seferId`
    FOREIGN KEY (`seferId`)
    REFERENCES `umuttepe_turizm`.`sefer` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `umuttepe_turizm`.`ucret`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `umuttepe_turizm`.`ucret` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nereden` VARCHAR(8) NOT NULL,
  `nereye` VARCHAR(8) NOT NULL,
  `tutar` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `umuttepe_turizm`.`users`
-- -----------------------------------------------------
START TRANSACTION;
USE `umuttepe_turizm`;
INSERT INTO `umuttepe_turizm`.`users` (`id`, `kimlik_no`, `ad`, `soyadi`, `telefon_no`, `e_posta`, `sifre`) VALUES (1, '00000000000', 'Admin', 'Admin', '0000000000', 'admin@admin.com', '$2y$10$7USjrQBaL98bUFwmb.EMrulgxznsfwM274OuvaOCRDP9CN0SnI0fe');

COMMIT;


-- -----------------------------------------------------
-- Data for table `umuttepe_turizm`.`ucret`
-- -----------------------------------------------------
START TRANSACTION;
USE `umuttepe_turizm`;
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (1, 'İstanbul', 'Ankara', 200);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (2, 'Ankara', 'İstanbul', 200);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (3, 'İstanbul', 'İzmir', 300);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (4, 'İzmir', 'İstanbul', 300);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (5, 'İstanbul', 'Antalya', 450);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (6, 'Antalya', 'İstanbul', 450);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (7, 'Ankara', 'İzmir', 250);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (8, 'İzmir', 'Ankara', 250);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (9, 'Ankara', 'Antalya', 350);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (10, 'Antalya', 'Ankara', 350);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (11, 'İzmir', 'Antalya', 250);
INSERT INTO `umuttepe_turizm`.`ucret` (`id`, `nereden`, `nereye`, `tutar`) VALUES (12, 'Antalya', 'İzmir', 250);

COMMIT;

