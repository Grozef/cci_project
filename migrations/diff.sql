
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`book` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `author` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  `price` DOUBLE NOT NULL,
  `id_category` INT NULL,
  `Id_awarded` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`asso_cat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`asso_cat` (
  `id` INT NOT NULL,
  `id_cat` INT NULL,
  `id_book` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_asso_cat_book`
    FOREIGN KEY (`id_book`)
    REFERENCES `superbouquin`.`book` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`asso_award`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`asso_award` (
  `id` INT NOT NULL,
  `id_award` INT NULL,
  `id_book` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_asso_award_book1`
    FOREIGN KEY (`id_book`)
    REFERENCES `superbouquin`.`book` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superbouquin`.`user_info`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`user_info` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `direction` VARCHAR(255) NOT NULL,
  `postal_code` INT NOT NULL,
  `town` VARCHAR(255) NOT NULL,
  `country` VARCHAR(255) NOT NULL,
  `tel` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `superbouquin`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(180) NOT NULL,
  `roles` JSON NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `pseudonym` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user_user_info1`
    FOREIGN KEY (`id`)
    REFERENCES `superbouquin`.`user_info` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`ingroup`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`ingroup` (
  `id` INT NOT NULL,
  `id_group` INT NULL,
  `id_user` INT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ingroup_user`
    FOREIGN KEY (`id_user`)
    REFERENCES `superbouquin`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`reunion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`reunion` (
  `id` INT NOT NULL,
  `date_reunion` DATETIME NULL,
  `id_group` INT NULL,
  `id_place` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`place`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`place` (
  `id` INT NOT NULL,
  `name_place` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_place_reunion`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`reunion` (`id_place`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `superbouquin` ;

-- -----------------------------------------------------
-- Table `superbouquin`.`awarded`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`awarded` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_award` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_awarded_asso_award1`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`asso_award` (`id_award`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `superbouquin`.`category`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name_cat` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_category_asso_cat1`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`asso_cat` (`id_cat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `superbouquin`.`doctrine_migration_versions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`doctrine_migration_versions` (
  `version` VARCHAR(191) COLLATE 'utf8mb3_unicode_ci' NOT NULL,
  `executed_at` DATETIME NULL DEFAULT NULL,
  `execution_time` INT NULL DEFAULT NULL,
  PRIMARY KEY (`version`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `superbouquin`.`group`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `superbouquin`.`group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_book` INT NOT NULL,
  `name_group` INT NOT NULL,
  `creation_date` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_group_book1_idx` (`id_book` ASC) VISIBLE,
  CONSTRAINT `fk_group_book1`
    FOREIGN KEY (`id_book`)
    REFERENCES `superbouquin`.`book` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_ingroup1`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`ingroup` (`id_group`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_group_reunion1`
    FOREIGN KEY (`id`)
    REFERENCES `mydb`.`reunion` (`id_group`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
